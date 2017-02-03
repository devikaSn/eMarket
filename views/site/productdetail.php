<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Adsinfo;

?>
<div class="site-about">
   <?php
        $this->title = $product['adTitle'];
        $this->params['breadcrumbs'][] = 'Products / '.$this->title;
    ?>
    <h3><?= Html::encode(strtoupper($this->title))?></h3> 
    <div class="div-product-details">
    	<div class="product-detail-image">
            <img 
                 src = <?php echo $product['productImage'] ?>
            >
    	</div>

    	<div class="product-detail-description">
                <h5> Price: <b><?php echo $product['price'];?></b></h5>
	 			<p> 
                    <?php echo $product['adDescription']; ?>
                    <br><br>
                    <b> Contact Seller:</b><br>
	 				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php echo  $product['contactAddress']; ?><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Phone: <?php echo $product['contactNumber']; ?>
	 			</p>
    	</div>
    </div>
</div>