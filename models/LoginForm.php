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
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            //Gets the User object
            $user = $this->getUser();
            if(!$user) {
                 $this->addError($attribute, 'Incorrect username');
            } else {
                if(!$user->validatePassword($this->password)) {
                    $this->addError($attribute, 'Incorrect password');
                }
            }
        }
    }


    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $userObject = Userlogin::findOne(['username' => $this->username]);
            if(!$userObject == NULL) {
              if(password_verify($this->password, $userObject->password)) {
                return Yii::$app->user->login($this->getUser(), 3600*24*30);
              }
            }
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return Userlogin object|null
    */
    public function getUser()
    {
        //if this doesn't work, make the  findByUsername call with Userlogin
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }

}
