<?php defined('ALTUMCODE') || die() ?>
<!DOCTYPE html>
<html lang="<?= \Altum\Language::$code ?>" dir="<?= l('direction') ?>">
    <head>
        <title><?= \Altum\Title::get() ?></title>
        <base href="<?= SITE_URL; ?>">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <?php if(\Altum\Meta::$description): ?>
            <meta name="description" content="<?= \Altum\Meta::$description ?>" />
        <?php endif ?>
        <?php if(\Altum\Meta::$keywords): ?>
            <meta name="keywords" content="<?= \Altum\Meta::$keywords ?>" />
        <?php endif ?>

        <?php if(!settings()->main->se_indexing): ?>
            <meta name="robots" content="noindex">
        <?php endif ?>

        <link rel="alternate" href="<?= SITE_URL . \Altum\Router::$original_request ?>" hreflang="x-default" />
        <?php if(count(\Altum\Language::$active_languages) > 1): ?>
            <?php foreach(\Altum\Language::$active_languages as $language_name => $language_code): ?>
                <?php if(settings()->main->default_language != $language_name): ?>
                    <link rel="alternate" href="<?= SITE_URL . $language_code . '/' . \Altum\Router::$original_request ?>" hreflang="<?= $language_code ?>" />
                <?php endif ?>
            <?php endforeach ?>
        <?php endif ?>

        <?php if(!empty(settings()->main->favicon)): ?>
            <link href="<?= UPLOADS_FULL_URL . 'main/' . settings()->main->favicon ?>" rel="shortcut icon" />
        <?php endif ?>

        <link href="<?= ASSETS_FULL_URL . 'css/' . \Altum\ThemeStyle::get_file() . '?v=' . PRODUCT_CODE ?>" id="css_theme_style" rel="stylesheet" media="screen,print">
        <?php foreach(['custom.css'] as $file): ?>
            <link href="<?= ASSETS_FULL_URL . 'css/' . $file . '?v=' . PRODUCT_CODE ?>" rel="stylesheet" media="screen,print">
        <?php endforeach ?>

        <?= \Altum\Event::get_content('head') ?>

        <?php if(!empty(settings()->custom->head_js)): ?>
            <?= settings()->custom->head_js ?>
        <?php endif ?>

        <?php if(!empty(settings()->custom->head_css)): ?>
            <style><?= settings()->custom->head_css ?></style>
        <?php endif ?>
    </head>

    <body class="<?= l('direction') == 'rtl' ? 'rtl' : null ?> <?= \Altum\ThemeStyle::get() == 'dark' ? 'c_darkmode' : null ?>" data-theme-style="<?= \Altum\ThemeStyle::get() ?>">

        <div class="app-container">

            <?= $this->views['app_sidebar'] ?>

            <section class="app-content">
                <?php //ALTUMCODE:DEMO if(DEMO) echo include_view(THEME_PATH . 'views/partials/ac_banner.php', ['demo_url' => 'https://66analytics.com/demo/', 'product_name' => PRODUCT_NAME, 'product_url' => PRODUCT_URL]) ?>

                <?php require THEME_PATH . 'views/partials/admin_impersonate_user.php' ?>
                <?php require THEME_PATH . 'views/partials/announcements.php' ?>
                <?php require THEME_PATH . 'views/partials/cookie_consent.php' ?>

                <?= $this->views['app_menu'] ?>

                <div class="py-3 p-lg-5">
                    <?php require THEME_PATH . 'views/partials/ads_header.php' ?>

                    <main>
                        <?= $this->views['content'] ?>
                    </main>

                    <?php require THEME_PATH . 'views/partials/ads_footer.php' ?>
                </div>

                <footer class="d-print-none app-footer">
                    <div class="py-3 p-lg-5">
                        <?= $this->views['footer'] ?>
                    </div>
                </footer>
            </section>
        </div>

        <div id="loading" style="display: none;">
            <div class="text-center">
                <div class="spinner-grow text-primary" role="status">
                    <span class="sr-only"><?= l('global.loading') ?></span>
                </div>
            </div>
        </div>

        <?= \Altum\Event::get_content('modals') ?>

        <?php require THEME_PATH . 'views/partials/js_global_variables.php' ?>

        <?php foreach(['libraries/jquery.min.js', 'libraries/popper.min.js', 'libraries/bootstrap.min.js', 'custom.js', 'libraries/fontawesome.min.js', 'libraries/fontawesome-solid.min.js', 'libraries/fontawesome-brands.modified.js'] as $file): ?>
            <script src="<?= ASSETS_FULL_URL ?>js/<?= $file ?>?v=<?= PRODUCT_CODE ?>"></script>
        <?php endforeach ?>

        <?= \Altum\Event::get_content('javascript') ?>
    </body>
</html>
