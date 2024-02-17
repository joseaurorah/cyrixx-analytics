<?php defined('ALTUMCODE') || die() ?>


<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <nav aria-label="breadcrumb">
        <ol class="custom-breadcrumbs small">
            <li>
                <a href="<?= url('domains') ?>"><?= l('domains.breadcrumb') ?></a><i class="fa fa-fw fa-angle-right"></i>
            </li>
            <li class="active" aria-current="page"><?= l('domain_update.breadcrumb') ?></li>
        </ol>
    </nav>

    <?php $url = parse_url(SITE_URL); $host = $url['host'] . (mb_strlen($url['path']) > 1 ? $url['path'] : null); ?>

    <div class="d-flex justify-content-between">
        <h1 class="h4 text-truncate"><?= l('domain_update.header') ?></h1>

        <?= include_view(THEME_PATH . 'views/domains/domain_dropdown_button.php', ['id' => $data->domain->domain_id]) ?>
    </div>
    <p class="text-muted mb-4"><?= sprintf(l('domains.input.help'), '<strong>' . $_SERVER['SERVER_ADDR'] . '</strong>', '<strong>' . $host . '</strong>') ?></p>

    <div class="card">
        <div class="card-body">

            <form action="" method="post" role="form">
                <input type="hidden" name="token" value="<?= \Altum\Csrf::get() ?>" />

                <div class="form-group">
                    <label for="host"><i class="fa fa-fw fa-globe fa-sm text-muted mr-1"></i> <?= l('domains.input.host') ?></label>
                    <input type="text" id="host" name="host" class="form-control <?= \Altum\Alerts::has_field_errors('host') ? 'is-invalid' : null ?>" value="<?= $data->domain->host ?>" placeholder="<?= l('domains.input.host_placeholder') ?>" required="required" />
                    <?= \Altum\Alerts::output_field_error('host') ?>
                </div>

                <div class="form-group">
                    <label for="custom_index_url"><i class="fa fa-fw fa-sitemap fa-sm text-muted mr-1"></i> <?= l('domains.input.custom_index_url') ?></label>
                    <input type="text" id="custom_index_url" name="custom_index_url" class="form-control <?= \Altum\Alerts::has_field_errors('custom_index_url') ? 'is-invalid' : null ?>" value="<?= $data->domain->custom_index_url ?>" placeholder="<?= l('domains.input.custom_index_url_placeholder') ?>" />
                    <?= \Altum\Alerts::output_field_error('custom_index_url') ?>

                    <small class="form-text text-muted"><?= l('domains.input.custom_index_url_help') ?></small>
                </div>

                <div class="form-group">
                    <label for="custom_not_found_url"><i class="fa fa-fw fa-location-arrow fa-sm text-muted mr-1"></i> <?= l('domains.input.custom_not_found_url') ?></label>
                    <input type="text" id="custom_not_found_url" name="custom_not_found_url" class="form-control <?= \Altum\Alerts::has_field_errors('custom_not_found_url') ? 'is-invalid' : null ?>" value="<?= $data->domain->custom_not_found_url ?>" placeholder="<?= l('domains.input.custom_not_found_url_placeholder') ?>" />
                    <?= \Altum\Alerts::output_field_error('custom_not_found_url') ?>
                    <small class="form-text text-muted"><?= l('domains.input.custom_not_found_url_help') ?></small>
                </div>

                <button type="submit" name="submit" class="btn btn-block btn-primary"><?= l('global.update') ?></button>
            </form>

        </div>
    </div>
</div>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/domains/domain_delete_modal.php'), 'modals'); ?>
