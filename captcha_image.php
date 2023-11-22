<?php
require 'captcha.php';

$captcha = new Captcha();
$captchaString = $captcha->generateString();
$captcha->generateImage($captchaString);
?>
