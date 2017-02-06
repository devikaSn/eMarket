<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Userinfo;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'DealIn',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Products', 
                'url' => ['/site/products'],
                'options'=>['class'=>'dropdown'],
                'template' => '<a href="{url}" class="href_class">{label}</a>',
                'items' => [
                  ['label' => 'View All', 'url' => ['site/products']],
                  ['label' => 'Crafts', 'url' => ['site/crafts']],
                  ['label' => 'Electronics & Equipments', 'url' => ['site/electronics']],
                  ['label' => 'Fashion', 'url' => ['site/fashion']],
                  ['label' => 'Furniture', 'url' => ['site/furniture']],
                  ['label' => 'Search', 'url' => ['site/search']],
                ],
            ],  
            ['label' => 'Sign up', 
                'url' => ['/user/signup'],
                'visible' => Yii::$app->user->isGuest,
            ],
            ['label' => 'My Account', 
                'url' => ['/user/account'],
                'options'=>['class'=>'dropdown'],
                'template' => '<a href="{url}" class="href_class">{label}</a>',
                'visible' => !Yii::$app->user->isGuest&&!Userinfo::isUserAdmin(),
                'items' => [
                  ['label' => 'Manage my Ads', 'url' =>  ['user/myads']],
                  ['label' => 'Create New Ad', 'url' => ['user/createad']],
                  ['label' => 'Edit Profile', 'url' =>  ['user/account']],
                  ['label' => 'Change Password', 'url' =>  ['user/changepassword']],
                ],
            ], 

            ['label' => 'My Account', 
                'url' => ['/user/account'],
                'options'=>['class'=>'dropdown'],
                'template' => '<a href="{url}" class="href_class">{label}</a>',
                'visible' => !Yii::$app->user->isGuest && Userinfo::isUserAdmin(),
                'items' => [
                  ['label' => 'Manage Users', 'url' => ['user/listusers']],
                  ['label' => 'Edit Profile', 'url' =>  ['user/account']],
                  ['label' => 'Change Password', 'url' =>  ['user/changepassword']],
                  ['label' => 'Manage my Ads', 'url' =>  ['user/myads']],
                  ['label' => 'Create New Ad', 'url' => ['user/createad']],
                ],
            ], 
           
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : 
            (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; DealIn <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
