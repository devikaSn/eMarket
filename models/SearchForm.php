<?php

namespace app\models;

use Yii;
use yii\base\Model;


class SearchForm extends Model
{
	public $adTitle;
	public $categoryId;
	public $lowerPrice;
    public $upperPrice;
   

	public function rules()
	{
		return[
            [['categoryId'], 'required'],
            ['adTitle', 'isExceeding80'],
            [['lowerPrice'], 'number', 'numberPattern' => '/^\d{0,8}(\.\d{1,4})?$/','message' => 'Price must be a number which can be upto 8 digits and 4 decimals.'],
            [['upperPrice'], 'number', 'numberPattern' => '/^\d{0,8}(\.\d{1,4})?$/','message' => 'Price must be a number which can be upto 8 digits and 4 decimals.'],

		];
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