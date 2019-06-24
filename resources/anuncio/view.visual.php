<?php view('layouts.header') ?>

<?php if (isset($anuncio) && $anuncio instanceof \App\Model\Anuncio) : ?>
    <section id="app-content">

        <div class="split-columns">

            <div class="col-lg">

                <div class="bubble-box">
                    <div id="image-switcher">
                        <button class="fa fa-angle-left btn-car-full"></button>
                        <div class="images">

                            <?php if (!empty($anuncio->photo)) : ?>
                                <?php foreach ($anuncio->photo as $photo): ?>
                                    <img src="<?php route("photos/{$photo['name']}") ?>" class="img-responsive img-c">
                                <?php endforeach ?>
                            <?php else: ?>
                                <img src="<?php route("images/default.jpg") ?>" class="img-responsive img-c">
                            <?php endif ?>
                        </div>
                        <button class="fa fa-angle-right btn-car-full"></button>
                    </div>
                </div>

                <div class="bubble-box">
                    <div class="col-lg">
                        <div class="bubble-title">
                            <div class="flex">
                                <div class="an-date"><?php show($anuncio->created_at) ?></div>
                                <?php if (Auth::ok()): ?>
                                    <?php if ($anuncio->is_favorite): ?>
                                        <button class="fa fa-heart favorite"></button>
                                    <?php else: ?>
                                        <button class="far fa-heart favorite"></button>
                                    <?php endif ?>
                                <?php endif ?>
                            </div>
                        </div>
                        <h1 class="an-title"><?php show($anuncio->title) ?></h1>
                        <div class="an-price"><?php show($anuncio->price) ?></div>
                    </div>
                </div>

                <div class="bubble-box">
                    <div class="bubble-title">Descrição</div>
                    <div class="an-description"><?php show($anuncio->description) ?></div>
                </div>

            </div>

            <div class="col-sm">

                <div class="bubble-box">

                    <div class="bubble-title-big">Informações de contato</div>


                    <ul class="beauty-list">

                        <li class="b-item">
                            <div class="fa fa-phone b-icon fa-fw"></div>
                            <div class="b-text"><?php show($anuncio->author->phone) ?></div>
                        </li>

                        <li class="b-item">
                            <div class="fa fa-user b-icon fa-fw"></div>
                            <div class="b-text"><?php show($anuncio->author->name) ?></div>
                        </li>
                        <li class="b-item">
                            <div class="fa fa-map-marker-alt b-icon fa-fw"></div>
                            <div class="b-text"><?php show($anuncio->author->city) ?></div>
                        </li>

                    </ul>
                </div>

                <div class="bubble-box">
                    <div class="bubble-title-big">Detalhes do anúncio</div>

                    <ul class="beauty-list">

                        <li class="b-item">
                            <div class="fa fa-box-open b-icon fa-fw"></div>
                            <div class="b-text"><?php show($anuncio->is_used) ?></div>
                        </li>
                        <li class="b-item">
                            <div class="<?php show($anuncio->category->icon) ?> b-icon fa-fw"></div>
                            <div class="b-text"><?php show($anuncio->category->name) ?></div>
                        </li>
                    </ul>
                </div>
                <div class="bubble-box">
                    <div class="bubble-title-big">Compartilhar</div>

                    <div class="share-action">
                        <button class="fab fa-facebook-square btn-share"></button>
                        <button class="fab fa-whatsapp btn-share"></button>
                        <button class="fab fa-twitter btn-share"></button>
                    </div>
                </div>

                <?php if ($user = Auth::user()) if ($user->id == $anuncio->author->id): ?>

                    <div class="bubble-box">
                        <div class="bubble-title-big">Visualizações</div>

                        <div class="b-center"><?php show($anuncio->views, '0') ?></div>
                    </div>

                <?php endif ?>

            </div>

        </div>
    </section>
    <form action="<?php route("favorite/{$anuncio->id}/") ?>" id="favorite-form" method="post"></form>
<?php endif; ?>
<?php view('layouts.footer') ?>