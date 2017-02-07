<?php

namespace app\models;

use yii\db\ActiveRecord;

class Adsinfo extends ActiveRecord
{

	public function rules()
	{
		return[
            [['adTitle','subDescription', 'adDescription','categoryId','price'], 'required'],
            ['adDescription', 'isExceeding250'],
            ['adTitle', 'isExceeding80'],
            ['productImage', 'isExceeding250'], 
            ['subDescription', 'isExceeding80'],
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