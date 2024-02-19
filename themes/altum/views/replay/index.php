<?php defined('ALTUMCODE') || die() ?>

<header class="header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="custom-breadcrumbs small">
                <li><a href="<?= url('replays') ?>"><?= l('replays.breadcrumb') ?></a> <i class="fa fa-fw fa-angle-right"></i></li>
                <li class="active" aria-current="page"><?= l('replay.breadcrumb') ?></li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between">
            <h1 class="h3"><i class="fa fa-fw fa-xs fa-video text-gray-700"></i> <?= l('replay.header') ?></h1>

            <div>
                <?php if(!$this->team): ?>
                    <div class="dropdown">
                        <button type="button" class="btn btn-link text-secondary dropdown-toggle dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport">
                            <i class="fa fa-fw fa-ellipsis-v"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-right">
                            <a
                                    href="#"
                                    class="dropdown-item"
                                    data-toggle="modal"
                                    data-target="#replay_delete_modal"
                                    data-session-id="<?= $data->visitor->session_id ?>"
                            >
                                <i class="fa fa-fw fa-sm fa-trash-alt mr-2"></i> <?= l('global.delete') ?>
                            </a>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</header>

<section class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <?php
    /* Visitor */
    $icon = new \Jdenticon\Identicon([
        'value' => $data->visitor->visitor_uuid,
        'size' => 50
    ]);
    $data->visitor->icon = $icon->getImageDataUri();
    ?>

    <div class="mb-5 row justify-content-between">
        <div class="col-12 col-lg-4 mb-3">
            <div class="card border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-column text-truncate">
                            <small class="text-muted text-uppercase font-weight-bold"><?= l('replays.replay.visitor') ?></small>
                            <span class="h4 font-weight-bolder text-truncate">
                                <img src="<?= ASSETS_FULL_URL . 'images/countries/' . ($data->visitor->country_code ? mb_strtolower($data->visitor->country_code) : 'unknown') . '.svg' ?>" class="img-fluid icon-favicon mr-1" />

                                <span class="align-middle"><?= $data->visitor->country_code ? get_country_from_country_code($data->visitor->country_code) :  l('global.unknown') ?></span>
                            </span>
                        </div>

                        <?php if(($data->visitor->custom_parameters = json_decode($data->visitor->custom_parameters, true)) && count($data->visitor->custom_parameters)): ?>
                            <a href="<?= url('visitor/' . $data->visitor->visitor_id) ?>" class="mr-3" data-toggle="tooltip" title="<?= sprintf(l('visitors.visitor.custom_parameters'), count($data->visitor->custom_parameters)) ?>">
                                <span class="round-circle-md bg-gray-200 text-primary-700 p-3">
                                    <i class="fa fa-fw fa-lg fa-fingerprint"></i>
                                </span>
                            </a>
                        <?php else: ?>
                            <a href="<?= url('visitor/' . $data->visitor->visitor_id) ?>" class="mr-3">
                                <img src="<?= $data->visitor->icon ?>" class="visitor-avatar rounded-circle" alt="" />
                            </a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 mb-3">
            <div class="card border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-column">
                            <small class="text-muted text-uppercase font-weight-bold"><?= l('replays.replay.date') ?></small>
                            <span class="h4 font-weight-bolder" data-toggle="tooltip" title="<?= \Altum\Date::get($data->replay->date, 1) ?>"><?= \Altum\Date::get($data->replay->date, 2) ?></span>
                        </div>

                        <span class="round-circle-md bg-gray-200 text-primary-700 p-3">
                            <i class="fa fa-fw fa-lg fa-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 mb-3">
            <div class="card border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-column">
                            <small class="text-muted text-uppercase font-weight-bold"><?= l('replay.duration') ?></small>
                            <span class="h4 font-weight-bolder"><?= \Altum\Date::get_seconds_to_his((new \DateTime($data->replay->last_date))->getTimestamp() - (new \DateTime($data->replay->date))->getTimestamp()) ?></span>
                        </div>

                        <span class="round-circle-md bg-gray-200 text-primary-700 p-3">
                            <i class="fa fa-fw fa-lg fa-stopwatch"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 mb-3">
            <div class="card border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-column">
                            <small class="text-muted text-uppercase font-weight-bold"><?= l('replay.time_range') ?></small>
                            <span class="h4 font-weight-bolder"><?= \Altum\Date::get($data->replay->date, 3) ?> <i class="fa fa-fw fa-sm fa-arrow-right"></i> <?= \Altum\Date::get($data->replay->last_date, 3) ?></span>
                        </div>

                        <span class="round-circle-md bg-gray-200 text-primary-700 p-3">
                            <i class="fa fa-fw fa-lg fa-clock"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 mb-3">
            <div class="card border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-column">
                            <small class="text-muted text-uppercase font-weight-bold"><?= l('replay.events') ?></small>
                            <span class="h4 font-weight-bolder"><a href="#" data-toggle="modal" data-target="#replay_events_modal"><?= nr($data->replay->events) ?></a></span>
                        </div>

                        <span class="round-circle-md bg-gray-200 text-primary-700 p-3">
                            <i class="fa fa-fw fa-lg fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 mb-3">
            <div class="card border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-column">
                            <small class="text-muted text-uppercase font-weight-bold"><?= l('replay.expiration_date') ?></small>
                            <span class="h4 font-weight-bolder"><?= \Altum\Date::get_time_until($data->replay->expiration_date) ?></span>
                        </div>

                        <span class="round-circle-md bg-gray-200 text-primary-700 p-3">
                            <i class="fa fa-fw fa-lg fa-hourglass-half"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix d-flex justify-content-center" id="replay"></div>
</section>


<?php ob_start() ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/rrweb-player@latest/dist/style.css" />
<?php \Altum\Event::add_content(ob_get_clean(), 'head') ?>

<?php ob_start() ?>
<script src="https://cdn.jsdelivr.net/npm/rrweb-player@latest/dist/index.js"></script>

<script>
    /* Default loading state */
    let loading_html = $('#loading').html();
    $('#replay').html(loading_html);

    let player = null;

    $.ajax({
        type: 'GET',
        url: <?= json_encode(url('replay/read/' . $data->visitor->session_id)) ?>,
        success: (result) => {

            $('#replay').html('');

            /* Start the replayer */
            player = new rrwebPlayer({
                target: document.querySelector('#replay'),
                data: {
                    events: result.rows,
                    autoPlay: false,
                },
            });

            /* Set the content for the replay events modal */
            $('#replay_events_result').html(result.replay_events_html);

        },
        dataType: 'json'
    });
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_form.php', [
    'name' => 'replay',
    'resource_id' => 'session_id',
    'has_dynamic_resource_name' => false,
    'path' => 'replays/delete'
]), 'modals'); ?>
