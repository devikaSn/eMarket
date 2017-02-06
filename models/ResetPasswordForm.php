<?php

namespace app\models;

use Yii;
use yii\base\Model;


/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $confirmPassword;

     /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['password', 'confirmPassword'], 'required'],
            ['confirmPassword','compare', 'compareAttribute' => 'password','message' => 'Passwords are not matching']


        ];
    }
}