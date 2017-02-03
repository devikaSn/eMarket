<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = $pageTitle ?? 'Products';
$this->params['breadcrumbs'][] = 'Products';
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="div-product"> 
      <?php 
          if(count($productsArray) == 0) { ?>
            Sorry, no products to display
      <?php 
         }else { 

          foreach ($productsArray as $productInfo) {
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
                     <?php echo $productInfo['adDescription'] ?>
                    </p>
                  </div>

            </div>
      <?php
            } //end of for each loop
         // display pagination
         echo LinkPager::widget([
            'pagination' => $pagination,
         ]);
       }//end of else loop
      ?>    
    </div>
</div>

