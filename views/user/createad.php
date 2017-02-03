<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Create Ad';
$this->params['breadcrumbs'][] = 'My Account  / '. $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	    <div class="div-form">
	    	<br>
	    	<?= Html::activeDropDownList($model, 'categoryId',$items) ?>
	    	<br><br>
		    <?= $form->field($model, 'adTitle')->label("Product Title")->textInput(['autofocus' => true]) ?>
		    <?= $form->field($model, 'adDescription')->textArea()->label("Product Description") ?>
		    <?= $form->field($model, 'price')->label("Product Price") ?>
		    <?= $form->field($model, 'contactAddress')->textArea()->label("Contact Address") ?>
		    <?= $form->field($model, 'contactNumber')->label("Contact Number") ?>
		    <?= $form->field($upmodel, 'file')->fileInput() ?>
		    <div class="form-group">
		        <?= Html::submitButton('Create Ad', ['class' => 'btn btn-primary'],  array('name' => 'submitButton')) ?>
		    </div>
		</div>
	<?php ActiveForm::end(); ?>
</div>
