<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Adsinfo;
use app\models\Userinfo;

?>
<div class="site-about">
   <?php
        $this->title = $product['adTitle'];
        $this->params['breadcrumbs'][] = 'Products / '.$this->title;
    ?>
    <h3><?= Html::encode(strtoupper($this->title))?></h3> 
    <?php 
         $userInfo = Userinfo::find()->where(['userId' => $product['userId']])->one();
    ?>
    <div class="div-product-details">
    	<div class="product-detail-image">
           <?php 
              if($product['productImage'] == NULL) {
            ?> 
               <img 
              src = <?php echo 'uploads/placeholder.png' ?>
              >
            <?php
              }else {
            ?> 
               <img 
              src = <?php echo $product['productImage'] ?>
            >
            <?php

              }
            ?>
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
                        
                        <?php 
                            echo $userInfo['name']; 
                            echo ","; 
                            echo  $userInfo['contactAddress'];
                         ?><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <br><br>

                         <b style="color:#00628B"> Phone:</b> <br>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $userInfo['mobile']; ?>
                </h4>
    	</div>
    </div>
</div>