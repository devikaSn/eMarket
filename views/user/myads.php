<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;

$this->title = 'Ads by Me';
$this->params['breadcrumbs'][] = 'My Account  / '. $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="div-product"> 
      <?php 
          if(count($productsArray) == 0) { ?>
            Oops!! Looks like you haven't created any ads yet
      <?php 
         }else { 

          foreach ($productsArray as $productInfo) {
            $adId = $productInfo['adId'];
       ?>
              <div class="product-item">
                  <div class ="product-img" style="height:180px">
                   <?php 
                      if($productInfo['productImage'] == NULL) {
                    ?> 
                       <img 
                      src = <?php echo 'uploads/placeholder.png' ?>
                      >
                    <?php
                      }else {
                    ?> 
                       <img 
                      src = <?php echo $productInfo['productImage'] ?>
                    >
                    <?php

                      }
                    ?>
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
                       	<div class= "product-edit">

                           <?php echo Html::a('Edit Ad', ['/user/editad', 'adId' => $productInfo['adId']], ['class'=>'btn btn-default btn-sm']) ;  
                           ?>
                        </div><div class="product-del">
                           <?php echo Html::a('Delete',['/user/editad', 
                                        'adId' => $productInfo['adId'],
                                         'shouldDelete' => true],
                                          ['class'=>'btn btn-default btn-sm',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete?',
                                                // 'method' => 'post'
                                                ],
                                          ]
                                        ) ; 
                          ?> 
                     	</div>
                  </div>

            </div>
      <?php
            } //end of for each loop
      ?>
        </div>
      <?php
         // display pagination
         echo LinkPager::widget([
            'pagination' => $pagination,
         ]);
       }//end of else loop
      ?>    
</div>
