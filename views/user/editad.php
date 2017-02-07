<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Edit Ad';
$this->params['breadcrumbs'][] = 'My Account  / '. $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	    <div class="div-form">
	    	
		    <?= $form->field($model, 'adTitle')->label("Product Title")->textInput(['autofocus' => true]) ?>
		    <?= $form->field($model, 'subDescription')->label("Product Subtitle") ?>
		    <?= $form->field($model, 'adDescription')->textArea()->label("Product Description") ?>
		    <?= $form->field($model, 'price')->label("Product Price") ?>
		    <?= $form->field($upmodel, 'file')->fileInput() ?>
		    <div class="form-group">
		        <?= Html::submitButton('Save Changes', ['class' => 'btn btn-primary'],  array('name' => 'submitButton')) ?>
		    </div>
		</div>
	<?php ActiveForm::end(); ?>

	<!-- Display success flash message upon saving the changes -->
	<?php if (Yii::$app->session->hasFlash('success')): ?>
		  <div class="alert alert-success alert-dismissable">
		  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		  <h4><i class="icon fa fa-check"></i>Success!</h4>
		  <?= Yii::$app->session->getFlash('success') ?>
		  </div>
	<?php endif; ?>
</div>