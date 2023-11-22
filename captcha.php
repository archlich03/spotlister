<?php
    class Captcha {
        function generateString(){
            $length = 6;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }
        function generateImage($captchaString) {
            if (ob_get_level() > 0) {
                ob_end_clean();
            }
        
            header('Content-type: image/png');
            $_SESSION['captcha'] = $captchaString;
        
            $image = imagecreatetruecolor(200, 60);
            $backgroundColor = imagecolorallocate($image, 255, 255, 255);
            imagefill($image, 0, 0, $backgroundColor);
        
            $textColor = imagecolorallocate($image, 0, 0, 0);

            for ($i = 0; $i < 100; $i++) {
                imagesetpixel(
                    $image,
                    rand(0, imagesx($image)),
                    rand(0, imagesy($image)),
                    $textColor
                );
            }
            for ($i = 0; $i < 10; $i++) {
                imageline(
                    $image,
                    rand(0, imagesx($image)),
                    rand(0, imagesy($image)),
                    rand(0, imagesx($image)),
                    rand(0, imagesy($image)),
                    $textColor
                );
            }
            imagestring($image, 5, 10, 10, $captchaString, $textColor);
        
            imagepng($image);
            imagedestroy($image);
        }
        function verify() {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $userInput = strtoupper($_POST["captcha"]);
                $captchaText = strtoupper($_SESSION['captcha']);
    
                return $userInput === $captchaText;
            }
            return false;
        }
    }
?>