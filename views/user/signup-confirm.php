<?php
use yii\helpers\Html;
?>
<h1>Welcome to Deal In</h1>
<p>You have entered the following information:</p>

<ul>
    <li><label>Name</label>: <?= Html::encode($model->name) ?></li>
    <li><label>Email</label>: <?= Html::encode($model->email) ?></li>
    <li><label>mobile</label>: <?= Html::encode($model->mobile) ?></li>
</ul>
