<?php
use \year\user\helpers\UserHelper ;

foreach($users as $user): ?>
<div class="media">
    <a class="pull-left" href="<?= UserHelper::getSpaceUrl($user->primaryKey) ?>" target="_blank">
        <img class="media-object" src="<?= UserHelper::getIconUrl($user,$this) ?>." alt="...">
    </a>
    <div class="media-body">
        <h4 class="media-heading"><?= $user->username ?></h4>
        ...
    </div>
</div>
<?php endforeach; ?>