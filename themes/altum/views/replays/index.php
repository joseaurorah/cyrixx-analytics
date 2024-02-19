<?php defined('ALTUMCODE') || die() ?>

<header class="header">
    <div class="container">

        <div class="d-flex flex-column flex-xl-row justify-content-between mb-3">
            <div>
                <h1 class="h3 text-break"><?= sprintf(l('replays.header'), $this->website->host . $this->website->path) ?></h1>
            </div>

            <div>
                <button
                        id="daterangepicker"
                        type="button"
                        class="btn btn-sm btn-outline-secondary my-1"
                        data-min-date="<?= \Altum\Date::get($this->website->date, 4) ?>"
                        data-max-date="<?= \Altum\Date::get('', 4) ?>"
                >
                    <i class="fa fa-fw fa-calendar mr-lg-1"></i>
                    <span class="d-none d-lg-inline-block">
                        <?php if($data->datetime['start_date'] == $data->datetime['end_date']): ?>
                            <?= \Altum\Date::get($data->datetime['start_date'], 2, \Altum\Date::$default_timezone) ?>
                        <?php else: ?>
                            <?= \Altum\Date::get($data->datetime['start_date'], 2, \Altum\Date::$default_timezone) . ' - ' . \Altum\Date::get($data->datetime['end_date'], 2, \Altum\Date::$default_timezone) ?>
                        <?php endif ?>
                    </span>
                    <i class="fa fa-fw fa-caret-down d-none d-lg-inline-block ml-lg-1"></i>
                </button>

                <button type="button" class="btn btn-sm btn-outline-secondary d-print-none my-1" onclick="$('#filters').toggle();" data-toggle="tooltip" title="<?= l('analytics.filters.toggle') ?>">
                    <i class="fa fa-fw fa-filter"></i>
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-4 mb-3 mb-md-0">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <small class="text-muted text-uppercase font-weight-bold"><?= l('analytics.replays') ?></small>
                                <span class="h4 font-weight-bolder"><?= nr($data->replays_data->total) ?></span>
                            </div>

                            <span class="round-circle-md bg-gray-200 text-primary-700 p-3">
                                <i class="fa fa-fw fa-lg fa-video"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 mb-3 mb-md-0">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <small class="text-muted text-uppercase font-weight-bold"><?= l('replays.average_events_per_replay') ?></small>
                                <span class="h4 font-weight-bolder"><?= nr($data->replays_data->average_events) ?></span>
                            </div>

                            <span class="round-circle-md bg-gray-200 text-primary-700 p-3">
                                <i class="fa fa-fw fa-lg fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 mb-3 mb-md-0">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <small class="text-muted text-uppercase font-weight-bold"><?= l('replays.average_duration_per_replay') ?></small>
                                <span class="h4 font-weight-bolder"><?= \Altum\Date::get_seconds_to_his($data->average_duration) ?></span>
                            </div>

                            <span class="round-circle-md bg-gray-200 text-primary-700 p-3">
                                <i class="fa fa-fw fa-lg fa-stopwatch"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?= (new \Altum\View('partials/analytics/filters_wrapper', (array) $this))->run(['available_filters' => 'websites_visitors']) ?>
    </div>
</header>

<section class="container">

    <?= \Altum\Alerts::output_alerts() ?>

    <?php if(!count($data->replays)): ?>
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center justify-content-center py-3">
                    <img src="<?= ASSETS_FULL_URL . 'images/no_rows.svg' ?>" class="col-10 col-md-7 col-lg-4 mb-3" alt="<?= l('replays.basic.no_data') ?>" />
                    <h2 class="h4 text-muted"><?= l('replays.basic.no_data') ?></h2>
                    <p class="text-muted"><?= sprintf(l('replays.basic.no_data_help')) ?></a></p>
                </div>
            </div>
        </div>
    <?php else: ?>

        <div class="table-responsive table-custom-container">
            <table class="table table-custom">
                <thead>
                <tr>
                    <th><?= l('replays.replay.session') ?></th>
                    <th><?= l('replays.replay.date') ?></th>
                    <th><?= l('replays.replay.visitor') ?></th>
                    <th>
                        <div class="d-flex justify-content-end">
                            <div data-toggle="tooltip" title="<?= l('replays.delete') ?>">
                                <button
                                        type="button"
                                        class="btn btn-link text-secondary"
                                        data-toggle="modal"
                                        data-target="#replays_delete_modal"
                                >
                                    <i class="fa fa-fw fa-trash-alt fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data->replays as $row): ?>
                    <?php
                    /* Visitor */
                    $icon = new \Jdenticon\Identicon([
                        'value' => $row->visitor_uuid,
                        'size' => 50
                    ]);
                    $row->icon = $icon->getImageDataUri();
                    ?>

                    <tr data-session-id="<?= $row->session_id ?>">
                        <td class="text-nowrap">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center" data-toggle="tooltip" title="<?= l('replays.replay.sessions_replays') ?>">
                                    <a href="<?= url('replay/' . $row->session_id) ?>"><i class="fa fa-fw fa-play-circle fa-2x text-primary"></i></a>
                                </div>
                                <div class="d-flex flex-column">
                                    <?= sprintf(l('replays.replay.time_spent'), \Altum\Date::get_seconds_to_his($row->duration)) ?>
                                    <span class="text-muted"><?= sprintf(l('replays.replay.events'), nr($row->events)) ?></span>
                                </div>
                            </div>
                        </td>

                        <td class="text-nowrap">
                            <div class="d-flex flex-column text-muted">
                                <span><strong><?= \Altum\Date::get($row->date, 2) ?></strong></span>
                                <span><?= \Altum\Date::get($row->date, 3) ?> <i class="fa fa-fw fa-sm fa-arrow-right"></i> <?= \Altum\Date::get($row->last_date, 3) ?></span>
                            </div>
                        </td>

                        <td class="text-nowrap">
                            <div class="d-flex align-items-center">
                                <?php if(($row->custom_parameters = json_decode($row->custom_parameters, true)) && count($row->custom_parameters)): ?>
                                    <a href="<?= url('visitor/' . $row->visitor_id) ?>" class="mr-3" data-toggle="tooltip" title="<?= sprintf(l('visitors.visitor.custom_parameters'), count($row->custom_parameters)) ?>">
                                <span>
                                    <i class="fa fa-fw fa-2x fa-fingerprint text-primary"></i>
                                </span>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= url('visitor/' . $row->visitor_id) ?>" class="mr-3">
                                        <img src="<?= $row->icon ?>" class="visitor-avatar rounded-circle" alt="" />
                                    </a>
                                <?php endif ?>

                                <div class="d-flex flex-column">
                                    <div>
                                        <img src="<?= ASSETS_FULL_URL . 'images/countries/' . ($row->country_code ? mb_strtolower($row->country_code) : 'unknown') . '.svg' ?>" class="img-fluid icon-favicon mr-1" />
                                        <span class="align-middle"><?= $row->country_code ? get_country_from_country_code($row->country_code) :  l('global.unknown') ?></span>
                                    </div>
                                    <small class="text-muted"><?= l('visitors.visitor.since') ?> <span data-toggle="tooltip" title="<?= \Altum\Date::get($row->date, 1) ?>" class="text-muted"><?= \Altum\Date::get($row->date, 2) ?></span></small>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex justify-content-end">
                                <span data-toggle="tooltip" title="<?= l('global.delete') ?>">
                                    <button
                                            type="button"
                                            class="btn btn-link text-secondary "
                                            data-toggle="modal"
                                            data-target="#replay_delete_modal"
                                            data-session-id="<?= $row->session_id ?>"
                                    >
                                        <i class="fa fa-fw fa-trash-alt fa-sm"></i>
                                    </button>
                                </span>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3"><?= $data->pagination ?></div>
    <?php endif ?>

</section>

<input type="hidden" name="start_date" value="<?= \Altum\Date::get($data->datetime['start_date'], 1) ?>" />
<input type="hidden" name="end_date" value="<?= \Altum\Date::get($data->datetime['end_date'], 1) ?>" />
<input type="hidden" name="website_id" value="<?= $this->website->website_id ?>" />

<?php ob_start() ?>
<link href="<?= ASSETS_FULL_URL . 'css/libraries/daterangepicker.min.css' ?>" rel="stylesheet" media="screen,print">
<?php \Altum\Event::add_content(ob_get_clean(), 'head') ?>

<?php ob_start() ?>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/moment.min.js' ?>"></script>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/daterangepicker.min.js' ?>"></script>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/moment-timezone-with-data-10-year-range.min.js' ?>"></script>

<script>
    'use strict';

    moment.tz.setDefault(<?= json_encode($this->user->timezone) ?>);

    /* Daterangepicker */
    $('#daterangepicker').daterangepicker({
        startDate: <?= json_encode($data->datetime['start_date']) ?>,
        endDate: <?= json_encode($data->datetime['end_date']) ?>,
        minDate: $('#daterangepicker').data('min-date'),
        maxDate: $('#daterangepicker').data('max-date'),
        ranges: {
            <?= json_encode(l('global.date.today')) ?>: [moment(), moment()],
            <?= json_encode(l('global.date.yesterday')) ?>: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            <?= json_encode(l('global.date.last_7_days')) ?>: [moment().subtract(6, 'days'), moment()],
            <?= json_encode(l('global.date.last_30_days')) ?>: [moment().subtract(29, 'days'), moment()],
            <?= json_encode(l('global.date.this_month')) ?>: [moment().startOf('month'), moment().endOf('month')],
            <?= json_encode(l('global.date.last_month')) ?>: [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            <?= json_encode(l('global.date.all_time')) ?>: [moment($('#daterangepicker').data('min-date')), moment()]
        },
        alwaysShowCalendars: true,
        linkedCalendars: false,
        singleCalendar: true,
        locale: <?= json_encode(require APP_PATH . 'includes/daterangepicker_translations.php') ?>,
    }, (start, end, label) => {

        /* Redirect */
        redirect(`<?= url('replays') ?>?start_date=${start.format('YYYY-MM-DD')}&end_date=${end.format('YYYY-MM-DD')}`, true);

    });
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_form.php', [
    'name' => 'replay',
    'resource_id' => 'session_id',
    'has_dynamic_resource_name' => false,
    'path' => 'replays/delete'
]), 'modals'); ?>
