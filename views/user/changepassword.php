<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = 'My Account  / '. $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
 	 <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		    <div class="div-form">
			    <?= $form->field($model, 'oldPassword')->label("Password")->passwordInput(['autofocus' => true]) ?>
			    <?= $form->field($model, 'newPassword')->label("New Password")->passwordInput() ?>
			    <?= $form->field($model, 'newPasswordConfirmation')->label("New Password Again")->passwordInput() ?>
			    <div class="form-group">
			        <?= Html::submitButton('Save Changes', ['class' => 'btn btn-primary'],  array('name' => 'submitButton')) ?>
			    </div>
			</div>
	<?php ActiveForm::end(); ?>
	<!-- To display success message upon successful completion of changing password -->
	<?php if (Yii::$app->session->hasFlash('success')): ?>
	  <div class="alert alert-success alert-dismissable">
	  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	  <h4><i class="icon fa fa-check"></i>Success</h4>
	  <?= Yii::$app->session->getFlash('success') ?>
	  </div>
	<?php endif; ?>
	<!-- To display error message if user enters wrong password -->
	<?php if (Yii::$app->session->hasFlash('error')): ?>
	  <div class="alert alert-danger alert-dismissable">
	  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	  <h4><i class="icon fa fa-check"></i>Error</h4>
	  <?= Yii::$app->session->getFlash('error') ?>
	  </div>
	<?php endif; ?>
</div>
