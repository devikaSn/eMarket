<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


$this->title = 'Search';
$this->params['breadcrumbs'][] ='Products / '. $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

	  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		    <div class="div-form">
		    	<br>
		    	<?= Html::activeDropDownList($model, 'categoryId',$items) ?>
		    	<br><br>
			    <?= $form->field($model, 'adTitle')->label("Product Title")->textInput(['autofocus' => true]) ?>
			    <?= $form->field($model, 'lowerPrice')->label("Lower Price") ?>
			    <?= $form->field($model, 'upperPrice')->label("Upper Price") ?>
			    <div class="form-group">
			        <?= Html::submitButton('Search', ['class' => 'btn btn-primary'],  array('name' => 'submitButton')) ?>
			    </div>
			</div>
		<?php ActiveForm::end(); ?>
</div>