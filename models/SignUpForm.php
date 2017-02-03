<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Userlogin;

class SignUpForm extends Model
{
    public $name;
    public $email;
    public $mobile;
    public $password;
    public $confirmPassword;

    public function rules()
    {
        return [
            [['name', 'email','mobile','password','confirmPassword'], 'required'],
            ['email', 'email'],
            ['mobile', 'validateMobileNumber'],
            ['name', 'validateName'],
            ['password', 'passwordStrength'],
            ['email', 'checkForAccountDuplication'],
            ['confirmPassword','compare', 'compareAttribute' => 'password','message' => 'Passwords are not matching']
        ];
    }

    /*
        Validates the mobile number
    */
    public function validateMobileNumber($attribute, $params)
    {
        if (!preg_match('/^(\+\d{1,3}[- ]?)?\d{10}$/', $this->$attribute)) {
             $this->addError($attribute, 'Please enter a valid mobile number');
        }
    }

    /*
        Validates the name
    */
    public function validateName($attribute, $params) {

        $pattern = '/^([a-zA-Z]).{2,75}$/';  
        if(!preg_match($pattern, $this->$attribute))
            $this->addError($attribute, 'Name must contain only letters with a maximum length of 75 characters');
    }

    /*
        Validates the password
    */
    public function passwordStrength($attribute,$params)
    {
        $pattern = '/^(?=.*[a-zA-Z0-9]).{5,25}$/';  
        if(!preg_match($pattern, $this->$attribute))
            $this->addError($attribute, 'Password length must be between 5 and 25');
    }

    /*
        Checks if an account is already created with the email id given
    */
    public function checkForAccountDuplication($attribute,$params)
    {
       $recordAlreadyExists = Userlogin::find()
                ->where( [ 'username' => $this->$attribute ] )
                ->exists();
       if($recordAlreadyExists) 
             $this->addError($attribute, 'An account already exists with this email id');
    }
}
