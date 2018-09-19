<?php
use yii\widgets\DetailView;
use yii\bootstrap\Tabs ;

$asset = year\user\UserAsset::register($this);

?>

<?php $this->beginContent('@app/views/layouts/main.php') ?>

<?php
$spaceUserId = $_GET['u'];
$model = \year\user\models\User::findIdentity($spaceUserId);
?>

<div class="content">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">

                <div class="col-md-4">
                    <a href="#" class="thumbnail">
                        <?php if (empty($model->icon_url)) : ?>
                            <!--                        default  avatar image -->
                            <img src="<?= $asset->baseUrl . '/images/icon-3.gif' ?>" alt="..." class="img-circle">
                        <?php else: ?>
                            <img data-src="holder.js/100%x180" alt="...">
                        <?php endif; ?>
                    </a>
                </div>



            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-8">
                    <ul class="nav nav-pills">
                        <li class="active"><a href="#">Home <span class="badge">42</span></a></li>
                        <li><a href="#">Profile</a></li>
                        <li><a href="#">Messages <span class="badge">3</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">


        <div class="col-sm-3">
            <div class="panel panel-info">

                haha 这里 放user profile

                <a href="#" class="thumbnail">
                    <?php if (empty($model->icon_url)) : ?>
                        <!--                        default  avatar image -->
                        <img src="<?= $asset->baseUrl . '/images/icon-3.gif' ?>" alt="...">
                    <?php else: ?>
                        <img data-src="holder.js/100%x180" alt="...">
                    <?php endif; ?>
                </a>
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'username',
                        'email:email',
                        'icon_url:url',
                        'password',
                        // 'salt',
                        'status',
                        'last_login_ip',
                        'last_active_at',
                        'created_at',
                    ],
                ]) ?>
            </div>

        </div>
        <!-- /.blog-sidebar -->


        <div class="col-sm-9 blog-main">
            <div  class="row" >
                <?php
                echo Tabs::widget([
                     'items' => [
                         [
                             'label' => 'One',
                             'content' => 'Anim pariatur cliche...',
                             'active' => true
                         ],
                         [
                             'label' => 'Two',
                             'content' => 'Anim pariatur cliche...',
                            // 'headerOptions' => [...],
                             'options' => ['id' => 'myveryownID'],
                         ],
                         [
                             'label' => 'Dropdown',
                             'items' => [
                                  [
                                      'label' => 'DropdownA',
                                      'content' => 'DropdownA, Anim pariatur cliche...',
                                  ],
                                  [
                                      'label' => 'DropdownB',
                                      'content' => 'DropdownB, Anim pariatur cliche...',
                                  ],
                             ],
                         ],
                     ],
                 ]);
                ?>
            </div>

            <?= $content ?>

        </div>
        <!-- /.blog-main -->
    </div>

    <div>

<?php $this->endContent() ?>