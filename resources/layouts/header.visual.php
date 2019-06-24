<!doctype html>
<html lang="pt-br">
<head>

    <!-- Basic info -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo NAME ?></title>

    <!-- JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="<?php route('js/script.js') ?>"></script>

    <!-- CSS Styles-->
    <link rel="stylesheet" href="<?php route('css/style.css') ?>">
</head>
<body>

<div id="app">
    <div id="app-section">
        <header id="app-header">

            <div id="app-logo"><a href="<?php route('/') ?>">
                    <img src="<?php route('images/logo.png') ?>" class="img-responsive logo">
                </a>
            </div>

            <form action="<?php route('search') ?>" id="app-search" autocomplete="off">
                <button class="btn-tpr fa fa-search btn-search"></button>
                <input type="text" class="search inp-dark" autofocus placeholder="Busque por qualquer coisa" name="q">
            </form>

            <div id="app-user">
                <?php if (($user = Auth::user())): ?>
                    <a href="<?php route('anuncio/create') ?>">
                        <button class="fa fa-bullhorn btn-colorful"></button>
                    </a>
                    <a href="<?php route('favorites') ?>">
                        <button class="fa fa-heart btn-colorful"></button>
                    </a>
                    <button class="user fa fa-user-circle btn-highlight"></button>
                    <ul class="user-menu beauty-list">
                        <li class="b-item"><a href="<?php route('anuncio/list') ?>">
                                <div class="fa fa-th-list b-icon fa-fw"></div>
                                <div class="b-text">Meus anuncios</div>
                            </a></li>
                        <?php if ($user->level > 1): ?>
                            <li class="b-item"><a href="<?php route('category/list') ?>">
                                    <div class="fa fa-filter b-icon fa-fw"></div>
                                    <div class="b-text">Categorias</div>
                                </a></li>
                        <?php if($user->level >= 9): ?>
                            <li class="b-item"><a href="<?php route('users/manage') ?>">
                                    <div class="fa fa-user b-icon fa-fw"></div>
                                    <div class="b-text">Gerenciar usuários</div>
                                </a></li>
                        <?php endif; endif ?>
                        <li class="b-item"><a href="<?php route('logout') ?>">
                                <div class="fa fa-sign-out-alt b-icon fa-fw"></div>
                                <div class="b-text">Sair</div>
                            </a></li>
                    </ul>
                <?php else : ?>
                    <a href="<?php route('login') ?>">
                        <button class="btn-default">Login</button>
                    </a>
                    <a href="<?php route('register') ?>">
                        <button class="btn-highlight">Cadastre-se</button>
                    </a>
                <?php endif ?>
            </div>

        </header>