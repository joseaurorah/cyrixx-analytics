<?php defined('ALTUMCODE') || die() ?>

<h1><?= sprintf(l('help.setup.header'), settings()->main->title) ?></h1>

<p><?= l('help.setup.p1') ?></p>

<ol class="">
    <li class="mb-2">
        <?= l('help.setup.step1') ?>
    </li>
    <li class="mb-2">
        <?= sprintf(l('help.setup.step2'), url('websites')) ?>
    </li>
    <li class="mb-2">
        <?= l('help.setup.step3') ?>
    </li>
    <li class="mb-2">
        <?= l('help.setup.step4') ?>
    </li>
    <li class="mb-2">
        <?= l('help.setup.step5') ?>
    </li>
    <li class="mb-2">
        <?= l('help.setup.step6') ?>
    </li>
</ol>
