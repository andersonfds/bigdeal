<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo NAME ?></title>

    <link rel="stylesheet" href="<?php route('css/login.css') ?>">
</head>
<body>

<div id="app-login">

    <div class="j-center">
        <form id="app-form" method="post" autocomplete="off">

            <div class="form-group"><a href="<?php route('/') ?>">
                    <img src="<?php route('images/logo.png') ?>" class="logo-big">
                </a></div>

            <div class="form-group">
                <label for="identifier">E-Mail</label>
                <input type="email" id="identifier" autofocus name="identifier">
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password">
            </div>

            <div class="form-group">
                <button class="btn-full-highlight">Entrar</button>
            </div>

            <div class="form-group">
                <a href="<?php route('register') ?>">Cadastrar-se</a>
            </div>

            <?php if (has_error('login')): ?>
                <div class="lg-error"><?php echo get_error('login') ?></div>
            <?php endif ?>
        </form>
    </div>

</div>

</body>
</html>