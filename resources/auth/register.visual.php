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
                <label for="r-name">Nome</label>
                <input type="text" id="r-name" autofocus name="name">
            </div>

            <div class="form-group form-inline">
                <div>
                    <label for="r-state">Estado</label>
                    <input type="text" id="r-state" autofocus name="state" maxlength="2">
                </div>
                <div class="f-g-max">
                    <label for="r-city">Cidade</label>
                    <input type="text" id="r-city" autofocus name="city">
                </div>
            </div>

            <div class="form-group">
                <label for="r-phone">Telefone</label>
                <input type="tel" id="r-phone" autofocus name="phone">
            </div>

            <div class="form-group">
                <label for="r-email">E-Mail</label>
                <input type="email" id="r-email" autofocus name="email">
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password">
            </div>

            <div class="form-group">
                <button class="btn-full-highlight">Entrar</button>
            </div>

            <div class="form-group">
                <span>Já tem conta? Então </span>
                <a href="<?php route('login') ?>">Faça Login</a>
            </div>

            <?php if (has_error('register')): ?>
                <div class="lg-error"><?php echo get_error('register') ?></div>
            <?php endif ?>

        </form>
    </div>

</div>

</body>
</html>