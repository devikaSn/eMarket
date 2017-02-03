<?php
   use yii\widgets\LinkPager;
?>
<?php foreach ($models as $model): ?>
   <?= $model->adTitle; ?>
   <?= $model->adId; ?>
   <br/>
<?php endforeach; ?>
<?php
   // display pagination
   echo LinkPager::widget([
      'pagination' => $pagination,
   ]);
?>