<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
* UploadForm is the model behind the upload form.
*/
class UploadForm extends \yii\db\ActiveRecord 
{
	/**
	 * @var UploadedFile|Null file attribute
	 */
	public $file;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
	    return [
	       ['file','file', 'extensions' => 'jpeg, gif, png, jpg',],
	    ];
	}

	public static function tableName() {
		return 'uploadform';
	}
	// public function behaviors()
	// {
	//     return [
	//         [
	//             'class' => '\yiidreamteam\upload\FileUploadBehavior',
	//             'attribute' => 'fileUpload',
	//             'filePath' => '@webroot/uploads/[[pk]].[[extension]]',
	//             'fileUrl' => '/uploads/[[pk]].[[extension]]',
	//         ],
	//     ];
	// }
}