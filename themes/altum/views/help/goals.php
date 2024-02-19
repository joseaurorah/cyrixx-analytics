<?php defined('ALTUMCODE') || die() ?>

<h1><?= l('help.goals.header') ?></h1>
<p><?= l('help.goals.p1') ?></p>

<h2><?= l('help.goals.pageview.header') ?></h2>
<p><?= l('help.goals.pageview.p1') ?></p>
<p><?= l('help.goals.pageview.p2') ?></p>

<h2><?= l('help.goals.custom.header') ?></h2>
<p><?= l('help.goals.custom.p1') ?></p>
<p><?= l('help.goals.custom.p2') ?></p>
<p><?= l('help.goals.custom.p3') ?></p>
<ul>
    <li class="mb-2"><?= l('help.goals.custom.li1') ?></li>
    <li class="mb-2"><?= l('help.goals.custom.li2') ?></li>
    <li class="mb-2"><?= l('help.goals.custom.li3') ?></li>
</ul>
<p><?= l('help.goals.custom.p4') ?></p>

<pre id="pixel_key_html" class="pre-custom rounded"><?= settings()->analytics->pixel_exposed_identifier ?>.goal('my-goal');</pre>

<p><?= l('help.goals.custom.p5') ?></p>
