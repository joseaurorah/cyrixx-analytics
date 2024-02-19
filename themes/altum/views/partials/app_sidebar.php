<?php defined('ALTUMCODE') || die() ?>

<section class="app-sidebar d-print-none">
    <div class="app-sidebar-title">
        <a href="<?= url() ?>"><?= mb_substr(settings()->main->title, 0, 1) ?></a>
    </div>

    <ul class="app-sidebar-links">
        <li class="<?= \Altum\Router::$controller == 'Dashboard' && !string_ends_with('dashboard/goals', $_GET['altum']) ? 'active' : null ?>">
            <a href="<?= url('dashboard') ?>" data-toggle="tooltip" data-placement="right" title="<?= l('dashboard.menu') ?>"><i class="fa fa-fw fa-th"></i></a>
        </li>

        <?php if($this->user->plan_settings->websites_goals_limit != 0): ?>
        <li class="<?= \Altum\Router::$controller == 'Dashboard' && string_ends_with('dashboard/goals', $_GET['altum']) ? 'active' : null ?>">
            <a href="<?= url('dashboard/goals') ?>" data-toggle="tooltip" data-placement="right" title="<?= l('analytics.goals') ?>"><i class="fa fa-fw fa-bullseye"></i></a>
        </li>
        <?php endif ?>

        <li class="<?= \Altum\Router::$controller == 'Realtime' ? 'active' : null ?>">
            <a href="<?= url('realtime') ?>" data-toggle="tooltip" data-placement="right" title="<?= l('realtime.menu') ?>"><i class="fa fa-fw fa-clock"></i></a>
        </li>

        <?php if(!$this->website || ($this->website && $this->website->tracking_type == 'normal')): ?>
            <li class="<?= \Altum\Router::$controller == 'Visitors' ? 'active' : null ?>">
                <a href="<?= url('visitors') ?>" data-toggle="tooltip" data-placement="right" title="<?= l('visitors.menu') ?>"><i class="fa fa-fw fa-user-friends"></i></a>
            </li>

            <?php if(settings()->analytics->websites_heatmaps_is_enabled): ?>
            <li class="<?= \Altum\Router::$controller == 'Heatmaps' ? 'active' : null ?>">
                <a href="<?= url('heatmaps') ?>" data-toggle="tooltip" data-placement="right" title="<?= l('heatmaps.menu') ?>"><i class="fa fa-fw fa-fire"></i></a>
            </li>
            <?php endif ?>

            <?php if(settings()->analytics->sessions_replays_is_enabled): ?>
            <li class="<?= \Altum\Router::$controller == 'Replays' ? 'active' : null ?>">
                <a href="<?= url('replays') ?>" data-toggle="tooltip" data-placement="right" title="<?= l('replays.menu') ?>"><i class="fa fa-fw fa-video"></i></a>
            </li>
            <?php endif ?>
        <?php endif ?>

        <li class="<?= \Altum\Router::$controller == 'Websites' ? 'active' : null ?>">
            <a href="<?= url('websites') ?>" data-toggle="tooltip" data-placement="right" title="<?= l('websites.menu') ?>"><i class="fa fa-fw fa-server"></i></a>
        </li>

        <li class="<?= \Altum\Router::$controller == 'Teams' ? 'active' : null ?>">
            <a href="<?= url('teams') ?>" data-toggle="tooltip" data-placement="right" title="<?= l('teams.menu') ?>"><i class="fa fa-fw fa-user-shield"></i></a>
        </li>

        <?php if(settings()->analytics->domains_is_enabled): ?>
            <li class="<?= \Altum\Router::$controller == 'Domains' ? 'active' : null ?>">
                <a href="<?= url('domains') ?>" data-toggle="tooltip" data-placement="right" title="<?= l('domains.menu') ?>"><i class="fa fa-fw fa-globe"></i></a>
            </li>
        <?php endif ?>

        <li>
            <a href="<?= url('help') ?>" target="_blank" data-toggle="tooltip" data-placement="right" title="<?= l('help.menu') ?>"><i class="fa fa-fw fa-question"></i></a>
        </li>
    </ul>
</section>
