<?php

session_start();

require_once 'config.php';
require_once 'vendor/autoload.php';

use Recaptcha\ReCaptcha;

$reCaptcha = new ReCaptcha(
    RECAPTCHA_SITE_KEY,
    RECAPTCHA_SECRET_KEY,
    'form',
    2
);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teste Recaptcha</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="fluid-container">
    <div class="row my-3">
        <div class="col-12 text-center">
            <h1>Teste recaptcha</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-4 offset-4">

            <?php if (isset($_SESSION['success']) && !$_SESSION['success']): ?>
                <div class="alert alert-danger">
                    reCaptcha inválido, robôs não são permitidos!
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success']) && $_SESSION['success']): ?>
                <div class="alert alert-success">
                    Formulário enviado com sucesso!
                </div>
            <?php endif; ?>

            <form id="form" class="form" action="process_form.php" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <?php $reCaptcha->checkbox(); ?>

                <input class="btn btn-primary <?php $reCaptcha->buttonClass(); ?>" type="submit"
                       value="Enviar" <?php $reCaptcha->buttonAttributes(); ?>>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>

<?php $reCaptcha->script(); ?>

<?php session_destroy() ?>;
</body>
</html>
