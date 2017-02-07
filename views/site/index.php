<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
defined('YII_DEBUG') or define('YII_DEBUG',false);



$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <?php if(strlen($name) > 2) { ?>

               <h1>Welcome <?php echo $name ?>!</h1>
        <?php }else { ?>
        
               <h1>Welcome To DealIn!</h1>

       <?php } ?>
        

        <p class="lead">The coolest free classifieds website</p>

        <p><a class="btn btn-primary" href="index.php?r=site%2Fproducts">Browse Products</a></p>
    </div>

    <div class="body-content">

         <div class="div-product"> 

                <?php 
                    foreach ($latestProducts as $productInfo) {
                        $adId = $productInfo['adId'];
                 ?>
                    <div class="product-item">
                                <div class ="product-img">
                                    <img 
                                      src = <?php echo $productInfo['productImage'] ?>
                                    >
                                </div>
                                <div class="product-details">
                                    <h4>
                                       <?php 
                                            echo Html::a($productInfo['adTitle'], array(
                                                 'site/productdetail', 
                                                 'productId' => $adId,
                                                
                                             )); 
                                        ?>
                                    </h4>
                                    <p>
                                     <?php echo $productInfo['subDescription'] ?>
                                    </p>
                                </div>

                    </div>
                <?php
                    }
                ?>
                    
            </div>
    </div>
</div>
