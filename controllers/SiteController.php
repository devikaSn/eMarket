<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\helpers\Url;


use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignUpForm;
use app\models\Adsinfo;
use app\models\Productcategory;
use app\models\SearchForm;
use app\models\Userinfo;
use app\models\ForgotPassword;
use app\models\ResetPasswordForm;

class SiteController extends Controller
{
 
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
      // print_r(Yii::$app->user);exit;
        $productsArray = ArrayHelper::index(Adsinfo::find()->orderBy(['adId' => SORT_DESC])->limit(3)->all(), 'adId');
        $name = "";
        if(!Yii::$app->user->isGuest) {
          $userInfo = Userinfo::find()->where(['userId' => Yii::$app->user->id])->one();
          if(!$userInfo == NULL){
            $name = $userInfo->name;
          }
        }
        return $this->render('index',
             ['latestProducts' => $productsArray,
               'name' => $name,
             ]
        );
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
       
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //Checking if user is logged in
            if(!Yii::$app->user->isGuest) {
                 $isUserAdmin = Userinfo::isUserAdmin();
                 return $this->goBack();    
            }else {
               return $this->render('login', [
                  'model' => $model,
              ]);
            }
        }
        return $this->render('login', [
            'model' => $model,
        ]);      

    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        if(!Yii::$app->user->isGuest) {
           Yii::$app->user->logout();
        }
        return $this->goHome();
    }


    /**
     * Displays forgot passowrd page.
     *
     * @return string
     */
    public function actionForgotpassword() {

      $model = new ForgotPassword();
      if($model->load(Yii::$app->request->post()) && $model->validate()) {
        //redirect to reset password screen
        // $getToken=rand(0, 99999);
        // $getTime=date("H:i:s");
        // $token=md5($getToken.$getTime);
        // $namaPengirim="Owner Jsource Indonesia";
        // $emailadmin="devik@qburst.com";
        // $subjek="Reset Password";
        // $setpesan="you have successfully reset your password<br/>
        //     <a href='http://yourdomain.com/index.php?r=site/vertoken/view&token=".$token."'>Click Here to Reset Password</a>";


        // $name='=?UTF-8?B?'.base64_encode($namaPengirim).'?=';
        // $subject='=?UTF-8?B?'.base64_encode($subjek).'?=';
        // $headers="From: $name <{$emailadmin}>\r\n".
        //     "Reply-To: {$emailadmin}\r\n".
        //     "MIME-Version: 1.0\r\n".
        //     "Content-type: text/html; charset=UTF-8";
        //         mail($emailadmin,$subject,$setpesan,$headers);
        // $this->refresh();


        // Yii::$app->mailer->compose()
        // ->setFrom('devika@qburst.com')
        // ->setTo('devika@qburst.com')
        // ->setSubject('Reset your password')
        // ->setTextBody('Please click the below link to reset your password')
        // ->setHtmlBody('<b>HTML content</b>')
        // ->send();
        $resetModel = new ResetPasswordForm();

        return Yii::$app->response->redirect(Url::to(['site/resetpassword',
               'model' => $resetModel,
               'username' => $model->username
        ]));

      }
      return $this->render("forgotpassword", [
        'model' => $model,
      ]);
    }


      /**
     * Displays reset passowrd page.
     *
     * @return string
     */
    public function actionResetpassword($model,$username) {
        if($username) {
          print_r(username);die;
        }
        $model = new ResetPasswordForm();
        return $this->render("resetpassword", [
         'model' => $model,

      ]);
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays products page.
     *
     * @return string
     */
    public function actionProducts() {

        //preparing the query
       $query = Adsinfo::find();
       // get the total number of users
       $count = $query->count();
       //creating the pagination object
       $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 6]);
       $productsArray = $query->offset($pagination->offset)
          ->limit($pagination->limit)
          ->all();
       return $this->render('products', [
          'productsArray' => $productsArray,
          'pagination' => $pagination,
          'pageTitle' => 'Products'
       ]);
    }

    /**
     * Displays product detail page.
     *
     * @return string
     */
    public function actionProductdetail($productId) {
      
        if(!$productId == NULL) {
            $product = Adsinfo::findOne($productId);
            return $this->render('productdetail',
                 ['product' => $product]);
        }
        return $this->render('productdetail');
    }

     /**
     * Lists the products belonging to furniture category
     *
     * @return string
     */
    public function actionFurniture() {

       $query = Adsinfo::find()->where(['categoryId' => 1]);
       $count = $query->count();
       //creating the pagination object
       $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 6]);
       $productsArray = $query->offset($pagination->offset)
          ->limit($pagination->limit)
          ->all();
       return $this->render('products', [
          'productsArray' => $productsArray,
          'pagination' => $pagination,
          'pageTitle' => 'Furniture',
       ]);
    }

    /**
     * Lists the products belonging to fashion category
     *
     * @return string
     */
    public function actionFashion() {

       $query = Adsinfo::find()->where(['categoryId' => 2]);
       $count = $query->count();
       //creating the pagination object
       $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 6]);
       $productsArray = $query->offset($pagination->offset)
          ->limit($pagination->limit)
          ->all();
       return $this->render('products', [
          'productsArray' => $productsArray,
          'pagination' => $pagination,
          'pageTitle' => 'Fashion',
       ]);
    }

     /**
     * Lists the products belonging to Electronics & Equipments category
     *
     * @return string
     */
    public function actionElectronics() {

       $query = Adsinfo::find()->where(['categoryId' => 3]);
       $count = $query->count();
       //creating the pagination object
       $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 6]);
       $productsArray = $query->offset($pagination->offset)
          ->limit($pagination->limit)
          ->all();
       return $this->render('products', [
          'productsArray' => $productsArray,
          'pagination' => $pagination,
          'pageTitle' => 'Electronics & Equipments',
       ]);
    }
 
    /**
     * Lists the products belonging to Crafts category
     *
     * @return string
     */
    public function actionCrafts() {

       $query = Adsinfo::find()->where(['categoryId' => 4]);
       $count = $query->count();
       //creating the pagination object
       $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 6]);
       $productsArray = $query->offset($pagination->offset)
          ->limit($pagination->limit)
          ->all();
       return $this->render('products', [
          'productsArray' => $productsArray,
          'pagination' => $pagination,
          'pageTitle' => 'Crafts',
       ]);
    }

    public function actionSearchresults($categoryId,$lowerPrice,$upperPrice,$productTitle) {
        
        $query = new Adsinfo();
        //fetch the query from db
        if((!$categoryId == NULL) && ((!$lowerPrice == NULL) && (!$upperPrice == NULL))) {
            if($productTitle == NULL) {
                 $query = Adsinfo::find()->where(['categoryId' => $categoryId])->andWhere(['between', 'price', $lowerPrice, $upperPrice ]);
            }else {
                 $query = Adsinfo::find()->where(['categoryId' => $categoryId, 'adTitle' => $productTitle])->andWhere(['between', 'price', $lowerPrice, $upperPrice ]);
            }
           
        }else {
            if(($lowerPrice == NULL) && ($upperPrice == NULL)) {
                if($productTitle == NULL) {
                    $query = Adsinfo::find()->where(['categoryId' => $categoryId]);
                }else {
                    $query = Adsinfo::find()->where(['categoryId' => $categoryId, 'adTitle' => $productTitle]);
                }  
            }
        }
        
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 6]);
        $productsArray = $query->offset($pagination->offset)
                  ->limit($pagination->limit)
                  ->all();
         return $this->render('products', [
          'productsArray' => $productsArray,
          'pagination' => $pagination,
          'pageTitle' => 'Search Results',
       ]);
    }

     /**
     *  Displays the search form
     *
     * @return string
     */
    public function actionSearch() {

        $items = ArrayHelper::map(Productcategory::find()->all(), 'categoryId', 'categoryName');
        $model = new SearchForm();
         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
              //re directs to search results
              return Yii::$app->response->redirect(Url::to(['site/searchresults',
                'categoryId' => $model->categoryId,
                'lowerPrice' => $model->lowerPrice,
                'upperPrice' => $model->upperPrice,
                'productTitle' => $model->adTitle,
              ]));
         }else {
              return $this->render('search', [
                'model' => $model, 
                'items'=> $items,
            ]);
         }
    }

}
