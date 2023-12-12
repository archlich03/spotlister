<?php
require_once 'captcha.php';

$captcha = new Captcha();
$captchaString = $captcha->generateString();
$captcha->generateImage($captchaString);
?>