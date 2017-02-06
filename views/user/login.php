<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class ="div-form">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please fill out the following fields to login:</p>

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>
        
        <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>
    <p>
        You're new?? <a href="index.php?r=user%2Fsignup">Click here to register</a>
    </p>
    <br><br>
     <p>
        Forgot your password<a href="index.php?r=site%2Fforgotpassword">Click here to reset</a>
    </p>
</div>
