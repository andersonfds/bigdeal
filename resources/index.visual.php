<?php view('layouts.header') ?>

<?php if (isset($anuncios) && !empty($anuncios)): ?>
    <section id="app-content">
        <ul id="app-items">
            <?php foreach ($anuncios as $ad): if (is_array($ad)) ?>
                <li class="item"><a href="<?php route("anuncio/{$ad['id']}") ?>">
                <img src="<?php show($ad['photo']) ?>" class="img-responsive thumb">
                <div class="title"><?php show($ad['title']) ?></div>
                <div class="price"><?php show($ad['price']) ?></div>
                </a></li>
            <?php endforeach ?>
        </ul>

        <div class="paginator">
            <?php $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?>
            <?php if (is_numeric($page) || $page == 0): ?>
                <a href="?page=<?php echo ($page > 0) ? $page - 1 : 0; ?>">
                    <button class="fa fa-angle-left"></button>
                </a>
                <a href="?page=<?php echo $page + 1; ?>">
                    <button class="fa fa-angle-right"></button>
                </a>
            <?php endif ?>
        </div>
    </section>
<?php else: ?>

    <section id="app-error">
        <div>
            <div class="fa fa-frown fa-10x"></div>
            <div class="err-text">Nenhum anúncio aqui!</div>
        </div>
    </section>

<?php endif ?>

<?php view('layouts.footer') ?>