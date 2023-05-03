<?php
/**
 * This is the template for generating the migration class of a specified table.
 * DO NOT EDIT THIS FILE! It may be regenerated with Gii.
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @see https://getbootstrap.com/docs/5.3/forms/layout/
 *
 * @var yii\web\View $this
 * @var \year\gii\form\generators\form\Generator $generator
 * @var string $tableName full table name
 *
 * @var array $properties
 * @var array $labels the generated attribute labels (name => label)
 */
//var_dump($generator->generateLabelsFromComments);
//print_r($labels);
//print_r($properties);


?>


<h1><?= $generator->tableName ?></h1>
<form class="row gx-3 gy-2 align-items-center">
    <?php
    $i = 0 ;
    foreach ($properties as $property => $data): ?>
        <?php if($i<4): ?>
            <div class="col-sm-3">
        <?php else: ?>
            <div class="col-auto">
        <?php endif ?>
            <label class="visually-hidden" for="<?= $generator->generateClassName($property) ?>">
                <?= $labels[$property] ?>:
            </label>
            <input type="text" class="form-control" name="<?= $property ?>" id="<?= $generator->generateClassName($property) ?>" placeholder="<?= $property ?>">
        </div>

    <?php $i++ ; endforeach; ?>

    <div class="col-sm-3">
        <label class="visually-hidden" for="specificSizeInputGroupUsername">Username</label>
        <div class="input-group">
            <div class="input-group-text">@</div>
            <input type="text" class="form-control" id="specificSizeInputGroupUsername" placeholder="Username">
        </div>
    </div>
    <div class="col-auto">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="autoSizingCheck2">
            <label class="form-check-label" for="autoSizingCheck2">
                Remember me
            </label>
        </div>
    </div>

    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

