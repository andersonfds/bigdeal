<?php view('layouts.header') ?>

<section id="app-content-sm">

    <form method="post">

        <div class="form-group form-inline">
            <div>
                <label for="c-icon">Icon</label>
                <input type="text" id="c-icon" name="icon" value="<?php /** @var \App\Model\Category $category */
                show($category->icon) ?>">
            </div>

            <div class="f-g-max">

                <label for="c-name">Nome</label>
                <input type="text" id="c-name" name="name" value="<?php show($category->name) ?>">
            </div>
        </div>

        <div class="form-group">
            <button class="btn-full-highlight">Pronto!</button>
        </div>

    </form>

</section>

<?php view('layouts.footer') ?>
