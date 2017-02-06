<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Userlogin;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ForgotPassword extends Model
{
    public $username;

     /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username'], 'required'],
            ['username' , 'email'],
            ['username', 'doesUsernameExists'],


        ];
    }

    public function doesUsernameExists($attribute, $params) {

  		$recordAlreadyExists = Userlogin::find()
                ->where( [ 'username' => $this->$attribute ] )
                ->exists();
     
    	if($recordAlreadyExists == NULL) {
    		 $this->addError($attribute, 'There is no account with this email id');
    	}
    }
}