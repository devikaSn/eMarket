<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Userlogin;


class ChangePasswordForm extends Model
{

	public $oldPassword;
	public $newPassword;
	public $newPasswordConfirmation;
   

	public function rules()
	{
		return[
            [['oldPassword','newPassword','newPasswordConfirmation'], 'required'],
            ['newPasswordConfirmation','compare', 'compareAttribute' => 'newPassword','message' => 'New password and confirm password are not matching'],
		];
	}
  	
}