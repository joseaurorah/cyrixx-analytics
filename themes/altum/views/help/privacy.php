<?php defined('ALTUMCODE') || die() ?>

<h1><?= l('help.privacy.header') ?></h1>
<p><?= l('help.privacy.p1') ?></p>

<h2 class="h3 mt-5"><?= l('help.privacy.dnt.header') ?></h2>
<p><?= l('help.privacy.dnt.p1') ?></p>
<p><?= l('help.privacy.dnt.p2') ?></p>
<p><?= l('help.privacy.dnt.p3') ?></p>
<p><?= l('help.privacy.dnt.p4') ?></p>

<pre id="pixel_key_html" class="pre-custom rounded">&lt;script async src="<?= url('pixel/12345678910111213') ?>" data-ignore-dnt="true"&gt&lt;/script&gt</pre>

<h2 class="h3 mt-5"><?= l('help.privacy.optout.header') ?></h2>
<p><?= l('help.privacy.optout.p1') ?></p>
<p><?= l('help.privacy.optout.p2') ?></p>
<p><?= l('help.privacy.optout.p3') ?></p>
<p><?= l('help.privacy.optout.p4') ?></p>
<p><?= l('help.privacy.optout.p5') ?></p>

<?php if(settings()->analytics->sessions_replays_is_enabled): ?>
    <h2 class="h3 mt-5"><?= l('help.privacy.sessions_replays.header') ?></h2>
    <p><?= l('help.privacy.sessions_replays.p1') ?></p>

    <p><?= sprintf(l('help.privacy.sessions_replays.p2'), implode(', ', ['password', 'email', 'tel'])) ?></p>

    <p><?= sprintf(l('help.privacy.sessions_replays.p3'), implode(', ', ['username','name','firstname','surname','lastname','familyname','fullname','email','phone','','cell','cellphone','telephone','tel','postcode','postalcode','zip','zipcode','mobile','address','ssn','security','securitynum','socialsec','socialsecuritynumber','socsec','ppsn','nationalinsurancenumber','nin','dob','dateofbirth','password','pass','adgangskode','authpw','contrasena','contrasenya','contrasinal','cyfrinair','contraseña','fjalëkalim','focalfaire','creditcard','cc','ccnum','ccname','ccnumber','ccexpiry','ccexp','ccexpmonth','ccexpyear','cccvc','cccvv','cctype','cvc','cvv'])) ?></p>
<?php endif ?>
