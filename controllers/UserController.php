<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\UploadedFile;

use app\models\SignUpForm;
use app\models\Userlogin;
use app\models\Userinfo;
use app\models\LoginForm;
use app\models\CreateAdForm;
use app\models\UploadForm;
use app\models\Productcategory;
use app\models\Adsinfo;
use app\models\ChangePasswordForm;


class UserController extends Controller
{
   /*
    Sign up action
   */
   public function actionSignup()
    {
        $model = new SignUpForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
           
            // valid data received in $model is inserted into the userlogin table
            $userLoginObject = new Userlogin();
            $userLoginObject->username = $model->email;
            $userLoginObject->password = password_hash($model->password, PASSWORD_DEFAULT);
            $userLoginObject->save();
         
            if($userLoginObject->save(false)) {
                //Insert data to userinfo table
                $userInfoObject = new Userinfo();
                $userInfoObject->name = $model->name;
                $userInfoObject->mobile = $model->mobile;
                $userInfoObject->role = 0;
                $userInfoObject->userId = $userLoginObject->id;
                $userInfoObject->save();

                if($userInfoObject->save()) {
                    //logging in with the new account details
                    $loginObject = new LoginForm();
                    $loginObject->username = $userLoginObject->username;
                    $loginObject->password = $model->password;
                    if($loginObject->login()) {
                         if(!Yii::$app->user->isGuest) {
                            return $this->render('account', [
                                'model' => $userInfoObject,
                            ]);   
                        }
                    }
                }
            }
                            
        } else {
            // the sign up page is reloaded
            return $this->render('signup', ['model' => $model]);
        }
    }
    
    /*
    Edit Profile action
   */
    public function actionAccount() {
       
        $userId = Yii::$app->user->id; // the logged in user's id
        $model =Userinfo::find()->where(['userId' => $userId])->one();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            if($model->save()) {
                //Setting the flash message to indicate success
                Yii::$app->session->setFlash('success', "Your changes are saved successfully!!");
            }
        }
        return $this->render('account', [
            'model' => $model,
        ]);
    }

    /*
    Create Ad action
   */
    public function actionCreatead() {

        //Fetching product categories
        $items = ArrayHelper::map(Productcategory::find()->all(), 'categoryId', 'categoryName');
        $model = new Adsinfo();
        $upmodel = new UploadForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->save();
            $upmodel->file = UploadedFile::getInstance($upmodel, 'file');
            if($upmodel->file) {

                    $appendWithProductName= Adsinfo::find()
                        ->where(['adId' => Adsinfo::find()->max('adId')])
                        ->one();
                    $randomInteger = rand(1000,100000);
                    //Making a unique name for image
                    $imageName = "{$appendWithProductName->adId}xxx{$randomInteger}"; 
                    $upmodel->save();
                    $upmodel->file->saveAs('uploads/'.$imageName.'.'.$upmodel->file->extension);
                    $model->productImage = 'uploads/'.$imageName.'.'.$upmodel->file->extension;
            }
            //replace the following value with the logged in user id, once the login completes
            $model->userId = Yii::$app->user->id;
            $model->save();
            if($model->save()) {
                // redirect
                 return Yii::$app->response->redirect(Url::to(['user/myads',
              ]));
            }

        }else {
             return $this->render('createad', [
                'model' => $model, 
                'items'=> $items,
                'upmodel' => $upmodel,
            ]);
        }

      }

    /*
    Change Password action
   */
  public function actionChangepassword() {

    $model = new ChangePasswordForm();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {

        $userId = Yii::$app->user->id; //logged in user's session
        $matchingUser = Userlogin::findOne(['id' => $userId]);
        if(!$matchingUser == NULL) {
            if(password_verify($model->oldPassword, $matchingUser->password)) {
                $matchingUser->password = password_hash($model->newPassword, PASSWORD_DEFAULT);
                $matchingUser->save();
                if($matchingUser->save(false)) {
                   $model = new ChangePasswordForm();
                   Yii::$app->session->setFlash('success', "Your changes are saved successfully!");
                }
            }else {
                  Yii::$app->session->setFlash('error', "Incorrect password!");
            }
        }
    }
    return $this->render('changepassword', [
        'model' => $model,
    ]);
  }

  /*
    Display ads for mangae ads screen
  */
  public function actionMyads() {

       $query = Adsinfo::find()->where(['userId' => Yii::$app->user->id])
                ->orderBy(['adTitle' => SORT_ASC]);
       $count = $query->count();
       //creating the pagination object
       $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 6]);
       $productsArray = $query->offset($pagination->offset)
          ->limit($pagination->limit)
          ->all();
       return $this->render('myads', [
          'productsArray' => $productsArray,
          'pagination' => $pagination,
       ]);  
  }

  /*
    Handles edit ad and delete ad action
  */
  public function actionEditad($adId, $shouldDelete = false) {
    
    $model = Adsinfo::find()->where(['adId' => $adId])->one();
    if($shouldDelete) {

       //perform deletion
       $model->delete();
       return Yii::$app->response->redirect(Url::to(['user/myads',
       ]));
       
    }else {

      //performing edit ad operation
    
      $upmodel = new UploadForm();
      if(!$model == NULL) {

          if ($model->load(Yii::$app->request->post()) && $model->validate()) {
          
               //Setting the flash message to indicate success
              $upmodel->file = UploadedFile::getInstance($upmodel, 'file');
              if($upmodel->file) {

                  $appendWithProductName= $model->adId;
                  //unlinking the old image
                  unlink(Yii::$app->basePath.'/web/'.$model->productImage);
                  $randomInteger = rand(1000,100000);
                  //Making a unique name for image
                  $imageName = "{$appendWithProductName}yxyx{$randomInteger}"; 
                  $upmodel->save();
                  $upmodel->file->saveAs('uploads/'.$imageName.'.'.$upmodel->file->extension);
                  $model->productImage = 'uploads/'.$imageName.'.'.$upmodel->file->extension;
              }
      
              $model->save();
              if($model->save()) {
                 Yii::$app->session->setFlash('success', "Your changes are saved successfully!!");
              }
          }
          return $this->render('editad', [
                  'model' => $model,
                  'upmodel' => $upmodel,
          ]);  
      }
    }
  }

  /*
    Handles deletion of users
  */
  public function actionListusers() {

   
     $query = Userinfo::find()
                ->where(['<>', 'userId',Yii::$app->user->id])
                ->orderBy(['name' => SORT_ASC]);
     $count = $query->count();
       //creating the pagination object
     $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 6]);
     $usersArray = $query->offset($pagination->offset)
          ->limit($pagination->limit)
          ->all();
     return $this->render('listusers', [
        'usersArray' => $usersArray,
        'pagination' => $pagination,
     ]);  
  } 

 /*
  Deletes the users
 */
  public function actionDeleteuser($userId) {
      $model = Userinfo::find()->where(['userId' => $userId])->one();
      if($model) {
          //deleting from userinfo table
          $model->delete();
          $loginmodel = Userlogin::find()->where(['id' => $userId])->one();
          //deleting from userinfo table
          $loginmodel->delete();
           //deleting user's ads
          Yii::$app
              ->db
              ->createCommand()
              ->delete('adsinfo', ['userId' => $userId])
              ->execute();
          // $adsmodel->delete();
          return Yii::$app->response->redirect(Url::to(['user/listusers',
          ]));
      }
   
  }
}
