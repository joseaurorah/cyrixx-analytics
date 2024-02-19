<?php defined('ALTUMCODE') || die() ?>

<header class="header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="custom-breadcrumbs small">
                <li><a href="<?= url('teams') ?>"><?= l('teams.breadcrumb') ?></a> <i class="fa fa-fw fa-angle-right"></i></li>
                <li class="active" aria-current="page"><?= l('team.breadcrumb') ?></li>
            </ol>
        </nav>

        <div class="d-flex flex-column flex-md-row justify-content-between">
            <div>
                <h1 class="h3"><?= sprintf(l('team.header'), $data->team->name) ?></h1>

                <p>
                    <?php foreach($data->team->websites_ids as $website_id): ?>
                        <span class="badge badge-primary mr-1"><?= $this->websites[$website_id]->host . $this->websites[$website_id]->path ?></span>
                    <?php endforeach ?>
                </p>
            </div>
        </div>

    </div>
</header>

<section class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <div class="row mb-4">
        <div class="col-12 col-xl d-flex align-items-center mb-3 mb-xl-0">
            <h2 class="h4 m-0"><?= l('team.teams_associations.header') ?></h2>

            <div class="ml-2">
                <span data-toggle="tooltip" title="<?= l('team.teams_associations.subheader') ?>">
                    <i class="fa fa-fw fa-info-circle text-muted"></i>
                </span>
            </div>
        </div>

        <div class="col-12 col-xl-auto d-flex">
            <button type="button" data-toggle="modal" data-target="#team_association_create_modal" class="btn btn-primary rounded-pill"><i class="fa fa-fw fa-plus-circle"></i> <?= l('team.teams_associations.create') ?></button>
        </div>
    </div>

    <?php if($data->teams_associations_result->num_rows): ?>
        <div class="table-responsive table-custom-container">
            <table class="table table-custom">
                <thead>
                <tr>
                    <th><?= l('team.teams_associations.user') ?></th>
                    <th><?= l('team.teams_associations.date') ?></th>
                    <th><?= l('team.teams_associations.is_accepted') ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <?php while($team_association = $data->teams_associations_result->fetch_object()): ?>
                    <tr data-team-association-id="<?= $team_association->team_association_id ?>">
                        <td>
                            <div class="d-flex">

                                <?php if($team_association->is_accepted): ?>
                                    <img src="<?= get_gravatar($team_association->email) ?>" class="team-user-avatar rounded-circle shadow-sm mr-3" alt="" />

                                    <div class="d-flex flex-column">
                                        <span class="font-weight-bold"><?= $team_association->name ?></span>
                                        <span class="text-muted"><?= $team_association->email ?></span>
                                    </div>
                                <?php else: ?>
                                    <img src="<?= get_gravatar($team_association->user_email) ?>" class="team-user-avatar rounded-circle shadow-sm mr-3" alt="" />

                                    <div class="d-flex flex-column align-self-center">
                                        <span class="text-muted"><?= $team_association->user_email ?></span>
                                    </div>
                                <?php endif ?>
                            </div>
                        </td>

                        <td class="text-muted">
                            <?= \Altum\Date::get($team_association->date, 2) ?>
                        </td>

                        <td>
                            <?php if($team_association->is_accepted): ?>
                                <span class="badge badge-pill badge-success">
                                <i class="fa fa-fw fa-check"></i> <?= l('team.teams_associations.accepted_date') ?>
                            </span>
                                <small class="text-muted"><?= \Altum\Date::get($team_association->date, 2) ?></small>
                            <?php else: ?>
                                <span class="badge badge-pill badge-warning">
                                <?= l('team.teams_associations.is_accepted_invited') ?>
                            </span>
                            <?php endif ?>
                        </td>

                        <td class="text-nowrap">
                            <div class="d-flex justify-content-end">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-link text-secondary dropdown-toggle dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport">
                                        <i class="fa fa-fw fa-ellipsis-v"></i>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a
                                                href="#"
                                                class="dropdown-item"
                                                data-toggle="modal"
                                                data-target="#team_association_delete"
                                                data-team-association-id="<?= $team_association->team_association_id ?>"
                                        >
                                            <i class="fa fa-fw fa-times fa-sm mr-1"></i> <?= l('global.delete') ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile ?>

                </tbody>
            </table>
        </div>

    <?php else: ?>
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center justify-content-center py-3">
                    <img src="<?= ASSETS_FULL_URL . 'images/no_rows.svg' ?>" class="col-10 col-md-7 col-lg-4 mb-3" alt="<?= l('team.teams_associations.no_data') ?>" />
                    <h2 class="h4 text-muted"><?= l('team.teams_associations.no_data') ?></h2>
                    <p class="text-muted"><?= l('team.teams_associations.no_data_help') ?></a></p>
                </div>
            </div>
        </div>
    <?php endif ?>
</section>
