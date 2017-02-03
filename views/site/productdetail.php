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
               <br><br><br>
                <h4>
                    <b style="color:#00628B"> Price: </b> <?php echo $product['price'];?><br><br>
                    <b style="color:#00628B"> Product Description: </b>

    	 			<p> 
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         <?php echo $product['adDescription']; ?> 
                        <br><br>
    	 			</p>
                        <b style="color:#00628B"> Contact Seller:</b><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        
                        <?php echo  $product['contactAddress']; ?><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <br><br>

                         <b style="color:#00628B"> Phone:</b> <br>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $product['contactNumber']; ?>
                </h4>
    	</div>
    </div>
</div>