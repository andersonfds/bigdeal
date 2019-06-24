<?php view('layouts.header') ?>
<?php if (isset($categories)): ?>
    <section id="app-content-sm">
        <form method="post" id="app-create-form" enctype="multipart/form-data">

            <div class="form-group">
                <div class="img-up-sec">
                    <div class="add-img-button fa fa-upload"></div>

                    <?php if (isset($photos)) foreach ($photos as $photo): ?>
                        <img src="<?php route("photos/${photo['name']}") ?>">
                    <?php endforeach ?>
                </div>
                <input type="file" id="hide" accept="image/jpeg, image/png" name="photo[]" multiple>
            </div>
            <div class="form-group">
                <label for="sv-title">Título do anúncio</label>
                <input type="text" id="sv-title" name="title" value="<?php show($anuncio->title) ?>">
            </div>

            <div class="form-group">
                <label for="sv-description">Descrição do anúncio</label>
                <textarea name="description" id="sv-description"><?php show($anuncio->description) ?></textarea>
            </div>

            <div class="form-group form-inline">
                <div>
                    <label for="sv-price">Preço</label>
                    <input type="number" id="sv-price" step="0.01" name="price" value="<?php show($anuncio->price) ?>">
                </div>
                <div class="f-g-max">
                    <label for="sv-category">Categoria</label>

                    <select name="category" id="sv-category">

                        <?php foreach ($categories as $c): ?>
                            <?php $sel = $c['id'] == $anuncio->category ? 'selected ' : null; ?>
                            <option
                                <?php show($sel) ?>value="<?php show($c['id']) ?>"><?php show($c['name']) ?></option>
                        <?php endforeach ?>

                    </select>

                </div>
            </div>

            <div class="form-group">
                <div class="checkbox" data-for="is_used">
                    <div class="c-icon fa fa-check-square"></div>
                    <div class="c-title">O produto é usado</div>
                    <input type="hidden" name="is_used" value="<?php show($anuncio->is_used, 0) ?>">
                </div>
            </div>

            <div class="form-group">
                <button class="btn-full-highlight">Pronto!</button>
            </div>
        </form>
    </section>
<?php endif ?>
<?php view('layouts.footer') ?>