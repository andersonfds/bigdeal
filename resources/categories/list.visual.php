<?php view('layouts.header') ?>
<section id="app-content-sm">
    <?php if (isset($categories) && !empty($categories)): ?>

        <ul id="app-list">
            <?php foreach ($categories as $ad): ?>
                <li class="l-item" data-id="1">
                    <div class="l-icon"><span class="<?php show($ad['icon']) ?>"></span></div>
                    <div class="l-title"><a
                                href="<?php route("category/${ad['id']}/edit") ?>"><?php show($ad['name']) ?></a></div>
                </li>
            <?php endforeach ?>
        </ul>

    <?php endif ?>
    <button class="btn-full-highlight"><a href="<?php route('category/create') ?>">Criar nova categoria</a></button>
</section>
<?php view('layouts.footer') ?>
