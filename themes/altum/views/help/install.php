<?php defined('ALTUMCODE') || die() ?>

<h1><?= sprintf(l('help.install.header'), settings()->main->title) ?></h1>

<p><?= l('help.install.p1') ?></p>

<p><?= l('help.install.p2') ?></p>

<ol class="">
    <li class="mb-2">
        <?= l('help.install.step1') ?>
    </li>
    <li class="mb-2">
        <?= sprintf(l('help.install.step2'), url('websites')) ?>
    </li>
    <li class="mb-2">
        <?= l('help.install.step3') ?>
    </li>
    <li class="mb-2">
        <?= l('help.install.step4') ?>
    </li>
    <li class="mb-2">
        <?= l('help.install.step5') ?>
    </li>
    <li class="mb-2">
        <?= l('help.install.step6') ?>
    </li>
</ol>
