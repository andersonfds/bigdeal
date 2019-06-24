<?php view('layouts.header') ?>

<?php if (isset($users) && !empty($users)): ?>

    <section id="app-content-sm">
        <ul id="app-list">
            <?php foreach ($users as $ad): ?>
                <li class="l-item" data-id="1">
                    <div class="l-title"><a href="<?php route("users/manage/${ad['id']}") ?>"><?php show($ad['email']) ?></a></div>
                    <div class="l-level"><?php show($ad['level'])?></div>
                    <div class="l-buttons">
                        <a href="<?php route("users/${ad['id']}/leveldown") ?>">
                            <button class="fa fa-arrow-down"></button>
                        </a>
                        <a href="<?php route("users/${ad['id']}/levelup") ?>">
                            <button class="fa fa-arrow-up"></button>
                        </a>
                        <a href="<?php route("users/${ad['id']}/delete") ?>">
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
            <div class="err-text">Sem usuários adicionais</div>
        </div>
    </section>
<?php endif ?>
<?php view('layouts.footer') ?>
