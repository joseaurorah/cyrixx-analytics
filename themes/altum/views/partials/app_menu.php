<?php defined('ALTUMCODE') || die() ?>

<nav class="navbar app-navbar navbar-expand-lg navbar-light bg-white px-lg-5">
    <div class="container">

        <?php if(count($this->websites)): ?>
            <div class="dropdown">
                <a class="text-decoration-none" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
                    <img src="https://external-content.duckduckgo.com/ip3/<?= $this->website->host ?>.ico" class="img-fluid icon-favicon mr-1" /> <span class="text-gray-700"><?= $this->website->host . ($this->website->path ?? null) ?></span>
                    <i class="fa fa-fw fa-caret-down text-muted"></i>
                </a>

                <div class="dropdown-menu overflow-auto" style="max-height: 20rem;">
                    <?php foreach($this->websites as $row): ?>
                        <a href="<?= url('dashboard?website_id=' . $row->website_id . '&redirect=' . \Altum\Router::$controller_key) ?>" class="dropdown-item py-2">
                            <div class="text-truncate">
                                <img src="https://external-content.duckduckgo.com/ip3/<?= $row->host ?>.ico" class="img-fluid icon-favicon mr-1" />
                                <?= $row->host . ($row->path ?? null) ?>
                            </div>
                            <div class="text-truncate">
                                <?php if($row->is_enabled): ?>
                                    <small data-toggle="tooltip" title="<?= l('global.active') ?>"><i class="fa fa-fw fa-check text-success"></i></small>
                                <?php else: ?>
                                    <small data-toggle="tooltip" title="<?= l('global.disabled') ?>"><i class="fa fa-fw fa-slash text-warning"></i></small>
                                <?php endif ?>

                                <small class="text-muted"><?= l('websites.websites.tracking_type_' . $row->tracking_type) ?></small>
                            </div>
                        </a>
                    <?php endforeach ?>
                </div>
            </div>

        <?php if($this->team): ?>
            <div class="d-flex align-items-baseline ml-lg-3">
                <span class="text-muted"><?= sprintf(l('global.team.is_enabled'), '<strong>' . $this->team->name . '</strong>') ?></span>
                <small class="text-muted">&nbsp;(<a href="#" id="team_logout"><?= l('global.team.logout') ?></a>)</small>
            </div>

        <?php ob_start() ?>
            <script>
                $('#team_logout').on('click', event => {
                    delete_cookie('selected_team_id', <?= json_encode(COOKIE_PATH) ?>);
                    redirect('dashboard');

                    event.preventDefault();
                });
            </script>
            <?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
        <?php endif ?>
        <?php endif ?>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_navbar" aria-controls="main_navbar" aria-expanded="false" aria-label="<?= l('global.accessibility.toggle_navigation') ?>">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="main_navbar">
            <ul class="navbar-nav align-items-lg-center">

                <?php foreach($data->pages as $data): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= $data->url ?>" target="<?= $data->target ?>"><?= $data->title ?></a></li>
                <?php endforeach ?>

                <li class="ml-lg-3 dropdown">
                    <a class="nav-link dropdown-toggle dropdown-toggle-simple" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <img src="<?= get_gravatar($this->user->email) ?>" class="app-navbar-avatar mr-3" loading="lazy" />

                            <div class="d-flex flex-column mr-3">
                                <span class="text-gray-700"><?= $this->user->name ?></span>
                                <small class="text-muted"><?= $this->user->email ?></small>
                            </div>

                            <i class="fa fa-fw fa-caret-down"></i>
                        </div>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if(\Altum\Authentication::is_admin()): ?>
                            <a class="dropdown-item" href="<?= url('admin') ?>"><i class="fa fa-fw fa-sm fa-fingerprint mr-2"></i> <?= l('global.menu.admin') ?></a>
                            <div class="dropdown-divider"></div>
                        <?php endif ?>
                        <a class="dropdown-item" href="<?= url('teams') ?>"><i class="fa fa-fw fa-sm fa-user-shield mr-2"></i> <?= l('teams.menu') ?></a>
                        <a class="dropdown-item" href="<?= url('account') ?>"><i class="fa fa-fw fa-sm fa-wrench mr-2"></i> <?= l('account.menu') ?></a>
                        <a class="dropdown-item" href="<?= url('account-plan') ?>"><i class="fa fa-fw fa-sm fa-box-open mr-2"></i> <?= l('account_plan.menu') ?></a>
                        <?php if(settings()->payment->is_enabled): ?>
                            <a class="dropdown-item" href="<?= url('account-payments') ?>"><i class="fa fa-fw fa-sm fa-dollar-sign mr-2"></i> <?= l('account_payments.menu') ?></a>

                            <?php if(\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled): ?>
                                <a class="dropdown-item" href="<?= url('referrals') ?>"><i class="fa fa-fw fa-sm fa-wallet mr-2"></i> <?= l('referrals.menu') ?></a>
                            <?php endif ?>
                        <?php endif ?>
                        <a class="dropdown-item" href="<?= url('account-api') ?>"><i class="fa fa-fw fa-sm fa-code mr-2"></i> <?= l('account_api.menu') ?></a>
                        <a class="dropdown-item" href="<?= url('logout') ?>"><i class="fa fa-fw fa-sm fa-sign-out-alt mr-2"></i> <?= l('global.menu.logout') ?></a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
