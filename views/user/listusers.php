<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;

use app\models\Userlogin;

$this->title = 'Manage Users';
$this->params['breadcrumbs'][] = 'My Account  / '. $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="div-product"> 
      <?php 
          if(count($usersArray) == 0) { ?>
            Oops!! Looks like no users registered yet
      <?php 
         }else {  ?>
           <table style="width:100%">
            <tr>
              <th>Name</th>
              <th>Email</th> 
              <th>Mobile</th> 
              <th>Action</th>
            </tr>
      <?php
          foreach ($usersArray as $userInfo) {
            $adId = $userInfo['id'];
            $name = Userlogin::find()->where(['id' => $userInfo['userId']])->one();

       ?>

                       <tr style="height:50px;">
                          <td><?php echo $userInfo['name']; ?></td>
                          <td><?php echo $name['username']; ?></td>
                          <td><?php echo $userInfo['mobile']; ?></td> 
                          <td>
                            <div class="product-del" style ="float:left">
                                 <?php echo Html::a('Delete',['/user/deleteuser', 
                                              'userId' => $userInfo['id'],
                                               'shouldDelete' => true],
                                                ['class'=>'btn btn-default btn-sm',
                                                  'data' => [
                                                      'confirm' => 'Are you sure you want to delete?',
                                                      // 'method' => 'post'
                                                      ],
                                                ]
                                              ) ; 
                                ?> 
                          </td>
                       </tr>
      <?php
            }//end of for each loop
       ?>
       </table>
          <?php
         // display pagination
         echo LinkPager::widget([
            'pagination' => $pagination,
         ]);
       }//end of else loop
      ?>    
    </div>
</div>
