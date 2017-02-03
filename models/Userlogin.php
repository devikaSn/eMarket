<?php

namespace app\models;

use Yii;
use \yii\web\IdentityInterface;

/**
 * This is the model class for table "userlogin".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 */
class Userlogin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */


    public static function tableName()
    {
        return 'userlogin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string', 'max' => 80],
            // ['password', 'validatePassword'],
            [['username'], 'unique'],
            ['username', 'checkForAccountDuplication'],
        ];
    }

    // /**
    //  * @inheritdoc
    //  */
    // public function attributeLabels()
    // {
    //     return [
    //         'id' => 'ID',
    //         'username' => 'Email',
    //         'password' => 'Password',
    //     ];
    // }

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

    // /**
    //  * Validates the password.
    //  * This method serves as the inline validation for password.
    //  *
    //  * @param string $attribute the attribute currently being validated
    //  * @param array $params the additional name-value pairs given in the rule
    //  */
    // public function validatePassword($attribute, $params)
    // {
    //     if (!$this->hasErrors()) {
    //         $user = $this->getUser();

    //         if (!$user || !$user->validatePassword($this->password)) {
    //             $this->addError($attribute, 'Incorrect username or password.');
    //         }
    //     }
    // }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
 
}
