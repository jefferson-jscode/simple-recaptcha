<?php

session_start();

require_once 'config.php';
require_once 'vendor/autoload.php';

use Recaptcha\ReCaptcha;

$reCaptcha = new ReCaptcha(
    RECAPTCHA_SITE_KEY,
    RECAPTCHA_SECRET_KEY,
    'form',
    RECAPTCHA_VERSION
);

$_SESSION['success'] = $reCaptcha->verify($_POST);

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
