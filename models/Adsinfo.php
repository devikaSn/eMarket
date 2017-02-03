<?php

namespace app\models;

use yii\db\ActiveRecord;

class Adsinfo extends ActiveRecord
{

	public function rules()
	{
		return[
            [['adTitle', 'adDescription','contactAddress','contactNumber','categoryId','price'], 'required'],
            ['contactNumber', 'validateMobileNumber'],
            ['contactAddress', 'isExceeding250'],
            ['adDescription', 'isExceeding250'],
            ['adTitle', 'isExceeding80'],
            ['productImage', 'isExceeding250'], 
            [['price'], 'number', 'numberPattern' => '/^\d{0,8}(\.\d{1,4})?$/','message' => 'Price must be a number which can be upto 8 digits and 4 decimals.'],

		];
	}
	public static function tableName()
	{
	    return 'adsinfo';
	}

    // public function behaviors()
    // {
    //     return [
    //         [
    //             'class' => '\yiidreamteam\upload\FileUploadBehavior',
    //             'attribute' => 'file',
    //             'filePath' => '@webroot/uploads/[[pk]].[[extension]]',
    //             'fileUrl' => '/uploads/[[pk]].[[extension]]',
    //         ],
    //     ];
    // }

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
        Checking the description and address limit
    */
    public function isExceeding250($attribute,$params)
    {
        $pattern = '/^(?=.*[a-zA-Z0-9]).{1,250}$/';  
        if(!preg_match($pattern, $this->$attribute))
            $this->addError($attribute, 'Characters should not exceed 250');
    }

    /*
        Checking the description and address limit
    */
    public function isExceeding80($attribute,$params)
    {
        $pattern = '/^(?=.*[a-zA-Z0-9]).{1,80}$/';  
        if(!preg_match($pattern, $this->$attribute))
            $this->addError($attribute, 'Characters should not exceed 80');
    }
}