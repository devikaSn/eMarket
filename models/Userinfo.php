<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userinfo".
 *
 * @property integer $id
 * @property string $name
 * @property string $mobile
 * @property integer $role
 * @property integer $userId
 */
class Userinfo extends \yii\db\ActiveRecord
{
    // /**
    //  * @inheritdoc
    //  */
    // public static function tableName()
    // {
    //     return 'userinfo';
    // }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'mobile', 'role', 'userId','contactAddress'], 'required'],
            [['role', 'userId'], 'integer'],
            [['name'], 'string', 'max' => 80],
            ['mobile','validateMobileNumber'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'mobile' => 'Mobile',
            'role' => 'Role',
            'userId' => 'User ID',
            'contactAddress' => 'Contact Address',
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
       Checks if the logged in user is Admin
    */
     public function isUserAdmin() {

        $user = Userinfo::find()
                ->where(['userId' => Yii::$app->user->id])
                ->one();
        return $user->role;
    }
 
}
