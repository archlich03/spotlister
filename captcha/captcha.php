<?php
    class Captcha {
        function generateString(){
            $length = 5;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }
        function generateImage($captchaString) {
            session_start();
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
            for ($i=1; $i<=strlen($captchaString);$i++) {
                  $font_size=rand(22,27);
                  $r=rand(0,255);
                  $g=rand(0,255);
                  $b=rand(0,255);
                  $index=rand(1,10);
                  $x=15+(30*($i-1));
                  $x=rand($x-5,$x+5);
                  $y=rand(35,45);
                  $o=rand(-30,30);
                  $font_color = imagecolorallocate($image, $r ,$g, $b);
                  imagettftext($image, $font_size, $o, $x, $y ,  $font_color,'../fonts/'.$index.'.ttf',$captchaString[$i-1]);
              }
            imagepng($image);
            imagedestroy($image);
        }
        function verify($userInput, $captchaText) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $userInput = strtoupper($userInput);
                $captchaText = strtoupper($captchaText);
    
                if($userInput === $captchaText) {
                    return true;
                }
            }
            else {
                return false;
            }
        }
    }
?>