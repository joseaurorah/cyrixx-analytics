<?php defined('ALTUMCODE') || die() ?>

<header class="header">
    <div class="container">

        <div class="row">
            <div class="col-12 col-lg d-flex align-items-center mb-3 mb-lg-0">
                <h1 class="h3 m-0"><?= l('websites.header') ?></h1>

                <div class="ml-2">
                    <span data-toggle="tooltip" title="<?= l('websites.subheader') ?>">
                        <i class="fa fa-fw fa-info-circle text-muted"></i>
                    </span>
                </div>
            </div>

            <div class="col-12 col-lg-auto d-flex">
                <div>
                    <?php if(!$this->team): ?>
                        <?php if($this->user->plan_settings->websites_limit != -1 && count($this->websites) >= $this->user->plan_settings->websites_limit): ?>
                            <button type="button" class="btn btn-primary rounded-pill disabled" data-toggle="tooltip" title="<?= l('global.info_message.plan_feature_limit')  ?>">
                                <i class="fa fa-fw fa-sm fa-plus-circle"></i> <?= l('websites.create') ?>
                            </button>
                        <?php else: ?>
                            <button type="button" data-toggle="modal" data-target="#website_create_modal" class="btn btn-primary rounded-pill"><i class="fa fa-fw fa-plus-circle"></i> <?= l('websites.create') ?></button>
                        <?php endif ?>
                    <?php endif ?>
                </div>

                <div class="ml-3">
                    <div class="dropdown">
                        <button type="button" class="btn <?= count($data->filters->get) ? 'btn-outline-primary' : 'btn-outline-secondary' ?> rounded-pill filters-button dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport"><i class="fa fa-fw fa-sm fa-filter"></i></button>

                        <div class="dropdown-menu dropdown-menu-right filters-dropdown">
                            <div class="dropdown-header d-flex justify-content-between">
                                <span class="h6 m-0"><?= l('global.filters.header') ?></span>

                                <?php if(count($data->filters->get)): ?>
                                    <a href="<?= url('websites') ?>" class="text-muted"><?= l('global.filters.reset') ?></a>
                                <?php endif ?>
                            </div>

                            <div class="dropdown-divider"></div>

                            <form action="" method="get" role="form">
                                <div class="form-group px-4">
                                    <label for="filters_search" class="small"><?= l('global.filters.search') ?></label>
                                    <input type="search" name="search" id="filters_search" class="form-control form-control-sm" value="<?= $data->filters->search ?>" />
                                </div>

                                <div class="form-group px-4">
                                    <label for="filters_search_by" class="small"><?= l('global.filters.search_by') ?></label>
                                    <select name="search_by" id="filters_search_by" class="form-control form-control-sm">
                                        <option value="name" <?= $data->filters->search_by == 'name' ? 'selected="selected"' : null ?>><?= l('websites.filters.search_by_name') ?></option>
                                        <option value="host" <?= $data->filters->search_by == 'host' ? 'selected="selected"' : null ?>><?= l('websites.filters.search_by_host') ?></option>
                                    </select>
                                </div>

                                <div class="form-group px-4">
                                    <label for="filters_is_enabled" class="small"><?= l('global.filters.status') ?></label>
                                    <select name="is_enabled" id="filters_is_enabled" class="form-control form-control-sm">
                                        <option value=""><?= l('global.filters.all') ?></option>
                                        <option value="1" <?= isset($data->filters->filters['is_enabled']) && $data->filters->filters['is_enabled'] == '1' ? 'selected="selected"' : null ?>><?= l('global.active') ?></option>
                                        <option value="0" <?= isset($data->filters->filters['is_enabled']) && $data->filters->filters['is_enabled'] == '0' ? 'selected="selected"' : null ?>><?= l('global.disabled') ?></option>
                                    </select>
                                </div>

                                <div class="form-group px-4">
                                    <label for="filters_tracking_type" class="small"><?= l('websites.filters.tracking_type') ?></label>
                                    <select name="tracking_type" id="filters_tracking_type" class="form-control form-control-sm">
                                        <option value=""><?= l('global.filters.all') ?></option>
                                        <option value="normal" <?= isset($data->filters->filters['tracking_type']) && $data->filters->filters['tracking_type'] == 'normal' ? 'selected="selected"' : null ?>><?= l('websites.filters.tracking_type_normal') ?></option>
                                        <option value="lightweight" <?= isset($data->filters->filters['tracking_type']) && $data->filters->filters['tracking_type'] == 'lightweight' ? 'selected="selected"' : null ?>><?= l('websites.filters.tracking_type_lightweight') ?></option>
                                    </select>
                                </div>

                                <div class="form-group px-4">
                                    <label for="filters_order_by" class="small"><?= l('global.filters.order_by') ?></label>
                                    <select name="order_by" id="filters_order_by" class="form-control form-control-sm">
                                        <option value="date" <?= $data->filters->order_by == 'date' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                                        <option value="name" <?= $data->filters->order_by == 'name' ? 'selected="selected"' : null ?>><?= l('websites.filters.order_by_name') ?></option>
                                        <option value="host" <?= $data->filters->order_by == 'host' ? 'selected="selected"' : null ?>><?= l('websites.filters.order_by_host') ?></option>
                                    </select>
                                </div>

                                <div class="form-group px-4">
                                    <label for="filters_order_type" class="small"><?= l('global.filters.order_type') ?></label>
                                    <select name="order_type" id="filters_order_type" class="form-control form-control-sm">
                                        <option value="ASC" <?= $data->filters->order_type == 'ASC' ? 'selected="selected"' : null ?>><?= l('global.filters.order_type_asc') ?></option>
                                        <option value="DESC" <?= $data->filters->order_type == 'DESC' ? 'selected="selected"' : null ?>><?= l('global.filters.order_type_desc') ?></option>
                                    </select>
                                </div>

                                <div class="form-group px-4">
                                    <label for="filters_results_per_page" class="small"><?= l('global.filters.results_per_page') ?></label>
                                    <select name="results_per_page" id="filters_results_per_page" class="form-control form-control-sm">
                                        <?php foreach($data->filters->allowed_results_per_page as $key): ?>
                                            <option value="<?= $key ?>" <?= $data->filters->results_per_page == $key ? 'selected="selected"' : null ?>><?= $key ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="form-group px-4 mt-4">
                                    <button type="submit" name="submit" class="btn btn-sm btn-primary btn-block"><?= l('global.submit') ?></button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</header>

<section class="container">

    <?= \Altum\Alerts::output_alerts() ?>

    <?php if(count($this->websites)): ?>

        <div class="table-responsive table-custom-container">
            <table class="table table-custom">
                <thead>
                <tr>
                    <th><?= l('websites.websites.website') ?></th>
                    <th><?= l('websites.websites.usage') ?></th>
                    <th><?= l('websites.websites.is_enabled') ?></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <?php foreach($data->websites as $row): ?>
                    <tr data-website-id="<?= $row->website_id ?>">
                        <td class="text-nowrap">
                            <div class="d-flex flex-column">
                                <a
                                        href="#"
                                        data-toggle="modal"
                                        data-target="#website_update_modal"
                                        data-website-id="<?= $row->website_id ?>"
                                        data-domain-id="<?= $row->domain_id ?>"
                                        data-name="<?= $row->name ?>"
                                        data-scheme="<?= $row->scheme ?>"
                                        data-host="<?= $row->host . $row->path ?>"
                                        data-tracking-type="<?= $row->tracking_type ?>"
                                        data-events-children-is-enabled="<?= (bool) $row->events_children_is_enabled ?>"
                                        data-sessions-replays-is-enabled="<?= (bool) $row->sessions_replays_is_enabled ?>"
                                        data-excluded-ips="<?= $row->excluded_ips ?>"
                                        data-email-reports-is-enabled="<?= $row->email_reports_is_enabled ?>"
                                        data-is-enabled="<?= (bool) $row->is_enabled ?>"
                                >
                                    <?= $row->name ?>
                                </a>

                                <div class="d-flex align-items-center text-muted">
                                    <img src="https://external-content.duckduckgo.com/ip3/<?= $row->host ?>.ico" class="img-fluid icon-favicon mr-1" />

                                    <?= $row->host . $row->path ?>
                                </div>
                            </div>
                        </td>
                        <td class="text-nowrap text-muted">
                            <?php ob_start() ?>
                            <div class='d-flex flex-column p-3'>
                                <div class='d-flex justify-content-between my-1'>
                                    <div class='mr-3'><?= l('websites.websites.sessions_events') ?></div>
                                    <strong><?= nr($row->current_month_sessions_events) . '/' . ($this->user->plan_settings->sessions_events_limit === -1 ? '∞' : nr($this->user->plan_settings->sessions_events_limit, 1, true)) ?></strong>
                                </div>

                                <?php if($row->tracking_type == 'normal'): ?>
                                    <?php if($this->user->plan_settings->events_children_limit != 0): ?>
                                        <div class='d-flex justify-content-between my-1'>
                                            <div class='mr-3 text-truncate'><?= l('websites.websites.events_children') ?></div>
                                            <div class='font-weight-bold text-truncate'><?= nr($row->current_month_events_children) . '/' . ($this->user->plan_settings->events_children_limit === -1 ? '∞' : nr($this->user->plan_settings->events_children_limit, 1, true)) ?></div>
                                        </div>
                                    <?php endif ?>

                                    <?php if(settings()->analytics->sessions_replays_is_enabled && $this->user->plan_settings->sessions_replays_limit != 0): ?>
                                        <div class='d-flex justify-content-between my-1'>
                                            <div class='mr-3 text-truncate'><?= l('websites.websites.sessions_replays') ?></div>
                                            <div class='font-weight-bold text-truncate'><?= nr($row->current_month_sessions_replays) . '/' . ($this->user->plan_settings->sessions_replays_limit === -1 ? '∞' : nr($this->user->plan_settings->sessions_replays_limit, 1, true)) ?></div>
                                        </div>
                                    <?php endif ?>

                                    <?php if(settings()->analytics->websites_heatmaps_is_enabled && $this->user->plan_settings->websites_heatmaps_limit != 0): ?>
                                        <div class='d-flex justify-content-between my-1'>
                                            <div class='mr-3 text-truncate'><?= l('websites.websites.websites_heatmaps') ?></div>
                                            <div class='font-weight-bold text-truncate'><?= nr($row->heatmaps) . '/' . ($this->user->plan_settings->websites_heatmaps_limit === -1 ? '∞' : nr($this->user->plan_settings->websites_heatmaps_limit, 1, true)) ?></div>
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>

                                <?php if($this->user->plan_settings->websites_goals_limit != 0): ?>
                                    <div class='d-flex justify-content-between my-1'>
                                        <div class='mr-3 text-truncate'><?= l('websites.websites.websites_goals') ?></div>
                                        <div class='font-weight-bold text-truncate'><?= nr($row->goals) . '/' . ($this->user->plan_settings->websites_goals_limit === -1 ? '∞' : nr($this->user->plan_settings->websites_goals_limit, 1, true)) ?></div>
                                    </div>
                                <?php endif ?>
                            </div>
                            <?php $html = ob_get_clean() ?>

                            <a
                                    href="<?= url('account-plan') ?>"
                                    data-toggle="tooltip"
                                    data-html="true"
                                    title="<?= $html ?>"
                                    class="text-muted"
                            >
                                <i class="fa fa-fw fa-lg fa-info-circle"></i>
                            </a>
                        </td>
                        <td class="text-nowrap">
                            <?php if($row->is_enabled): ?>
                                <span class="badge badge-success">
                                    <i class="fa fa-fw fa-check"></i> <?= l('global.active') ?>
                                    <?php if($row->tracking_type == 'normal'): ?>
                                        - <?= l('websites.websites.tracking_type_normal') ?>
                                    <?php endif ?>

                                    <?php if($row->tracking_type == 'lightweight'): ?>
                                        - <?= l('websites.websites.tracking_type_lightweight') ?>
                                    <?php endif ?>
                                </span>
                            <?php else: ?>
                                <span class="badge badge-warning"><i class="fa fa-fw fa-eye-slash"></i> <?= l('global.disabled') ?></span>
                            <?php endif ?>
                        </td>

                        <td class="text-nowrap">
                            <?php if($row->tracking_type == 'normal'): ?>
                                <div>
                                    <?php if($this->user->plan_settings->events_children_limit != 0 && $row->events_children_is_enabled): ?>
                                        <span class="badge badge-success mx-1" data-toggle="tooltip" title="<?= l('websites.websites.events_children') ?>"><i class="fa fa-fw fa-mouse"></i></span>
                                    <?php else: ?>
                                        <span class="badge badge-warning mx-1" data-toggle="tooltip" title="<?= l('websites.websites.events_children') ?>"><i class="fa fa-fw fa-mouse"></i></span>
                                    <?php endif ?>

                                    <?php if(settings()->analytics->sessions_replays_is_enabled): ?>
                                        <?php if($this->user->plan_settings->sessions_replays_limit != 0 && $row->sessions_replays_is_enabled): ?>
                                            <span class="badge badge-success mx-1" data-toggle="tooltip" title="<?= l('websites.websites.sessions_replays') ?>"><i class="fa fa-fw fa-video"></i></span>
                                        <?php else: ?>
                                            <span class="badge badge-warning mx-1" data-toggle="tooltip" title="<?= l('websites.websites.sessions_replays') ?>"><i class="fa fa-fw fa-video"></i></span>
                                        <?php endif ?>
                                    <?php endif ?>

                                    <?php if(settings()->analytics->email_reports_is_enabled): ?>
                                        <?php if($this->user->plan_settings->email_reports_is_enabled && $row->email_reports_is_enabled): ?>
                                            <span class="badge badge-success mx-1" data-toggle="tooltip" title="<?= l('websites.websites.email_reports') ?>"><i class="fa fa-fw fa-envelope"></i></span>
                                        <?php else: ?>
                                            <span class="badge badge-warning mx-1" data-toggle="tooltip" title="<?= l('websites.websites.email_reports') ?>"><i class="fa fa-fw fa-envelope"></i></span>
                                        <?php endif ?>
                                    <?php endif ?>
                                </div>
                            <?php endif ?>
                        </td>

                        <td class="text-nowrap">
                            <div class="d-flex align-items-center justify-content-end">
                                <div data-toggle="tooltip" title="<?= l('websites.websites.pixel_key') ?>">
                                    <button
                                            type="button"
                                            class="btn btn-sm btn-outline-primary"
                                            data-toggle="modal"
                                            data-target="#website_pixel_key_modal"
                                            data-tracking-type="<?= $row->tracking_type ?>"
                                            data-pixel-key="<?= $row->pixel_key ?>"
                                            data-url="<?= $row->scheme . $row->host . $row->path ?>"
                                            data-base-url="<?= $row->domain_id ? $data->domains[$row->domain_id]->scheme . $data->domains[$row->domain_id]->host . '/' : SITE_URL ?>"
                                    ><i class="fa fa-fw fa-sm fa-code"></i></button>
                                </div>

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
                                                    data-target="#website_update_modal"
                                                    data-website-id="<?= $row->website_id ?>"
                                                    data-domain-id="<?= $row->domain_id ?>"
                                                    data-name="<?= $row->name ?>"
                                                    data-scheme="<?= $row->scheme ?>"
                                                    data-host="<?= $row->host . $row->path ?>"
                                                    data-tracking-type="<?= $row->tracking_type ?>"
                                                    data-events-children-is-enabled="<?= (bool) $row->events_children_is_enabled ?>"
                                                    data-sessions-replays-is-enabled="<?= (bool) $row->sessions_replays_is_enabled ?>"
                                                    data-excluded-ips="<?= $row->excluded_ips ?>"
                                                    data-email-reports-is-enabled="<?= $row->email_reports_is_enabled ?>"
                                                    data-is-enabled="<?= (bool) $row->is_enabled ?>"
                                            >
                                                <i class="fa fa-fw fa-sm fa-pencil-alt mr-1"></i> <?= l('global.edit') ?>
                                            </a>
                                            <a
                                                    href="#"
                                                    class="dropdown-item"
                                                    data-toggle="modal"
                                                    data-target="#website_delete_modal"
                                                    data-website-id="<?= $row->website_id ?>"
                                            >
                                                <i class="fa fa-fw fa-sm fa-trash-alt mr-1"></i> <?= l('global.delete') ?>
                                            </a>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>

                </tbody>
            </table>
        </div>

        <div class="mt-3"><?= $data->pagination ?></div>

    <?php else: ?>
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center justify-content-center py-3">
                    <img src="<?= ASSETS_FULL_URL . 'images/no_rows.svg' ?>" class="col-10 col-md-7 col-lg-4 mb-3" alt="<?= l('websites.websites.no_data') ?>" />
                    <h2 class="h4 text-muted"><?= l('websites.websites.no_data') ?></h2>
                    <p class="text-muted"><?= l('websites.websites.no_data_help') ?></a></p>
                </div>
            </div>
        </div>
    <?php endif ?>

</section>

<?php \Altum\Event::add_content((new \Altum\View('websites/website_create_modal', (array) $this))->run($data), 'modals'); ?>
<?php \Altum\Event::add_content((new \Altum\View('websites/website_update_modal', (array) $this))->run($data), 'modals'); ?>
<?php \Altum\Event::add_content((new \Altum\View('websites/website_pixel_key_modal', (array) $this))->run($data), 'modals'); ?>
<?php \Altum\Event::add_content((new \Altum\View('websites/website_delete_modal', (array) $this))->run($data), 'modals'); ?>
