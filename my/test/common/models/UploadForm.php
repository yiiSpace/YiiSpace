<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/4/1
 * Time: 22:02
 */

namespace my\test\common\models;

use yii\base\Model;
use yii\validators\FileValidator;
use yii\web\UploadedFile;

/**
 * Class UploadForm
 * @package my\test\common\models
 *
 * @see https://www.yiiframework.com/doc/guide/2.0/en/input-file-upload
 */
class UploadForm extends Model

{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public function rules()
    {
        // FileValidator::className() ;
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

}