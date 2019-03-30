<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/3/28
 * Time: 13:32
 */

namespace my\test\common\models;

use Yii;
use yii\base\Model;
use yii\validators\FileValidator;

/**
 * Class FileModel
 *
 * @package my\test\common\models
 */
class FileModel extends Model{

    public $file;

    /**
     * @return array
     *
     * TODO: 很诡异的事情 excel导出文件如果开启MimeType验证就会出错！纯粹用后缀来验证就没事！
     *
     */
    public function rules(){
        //  FileValidator::
        return [
            // [['file'], 'file', 'extensions' =>['xls','xlsx','gif','jpg']  /* '.xls, .xlsx, .gif, .jpg'*/]
            [['file'], 'file',  'checkExtensionByMimeType'=>false,  'extensions' => 'xls, xlsx, gif, jpg' ],
//            [['file'], 'file',  'extensions' => 'xls, xlsx, gif, jpg' ],
        ];
    }

    public function attributeLabels(){
        return [
            'file'=>'文件上传'
        ];
    }

}
