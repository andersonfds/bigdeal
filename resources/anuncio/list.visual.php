<?php view('layouts.header') ?>

<?php if (isset($anuncios) && !empty($anuncios)): ?>

    <section id="app-content-sm">


        <ul id="app-list">

            <?php foreach ($anuncios as $ad): ?>
                <li class="l-item" data-id="1">
                    <div class="l-thumb"><img src="<?php show($ad['photo']) ?>" class="img-responsive"></div>
                    <div class="l-title"><a href="<?php route("anuncio/${ad['id']}") ?>"><?php show($ad['title']) ?></a></div>
                    <div class="l-buttons">
                        <a href="<?php route("anuncio/${ad['id']}/edit") ?>">
                            <button class="fa fa-pen"></button>
                        </a>
                        <a href="<?php route("anuncio/${ad['id']}/delete") ?>">
                            <button class="fa fa-trash"></button>
                        </a>

                    </div>
                </li>
            <?php endforeach ?>
        </ul>
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
