<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/3/28
 * Time: 13:31
 */

namespace my\test\frontend\controllers;

use codemix\excelexport\ExcelFile;
use common\behaviors\MultipleUploadEvent;
use common\behaviors\UploadBehavior;
use creocoder\flysystem\LocalFilesystem;
use frontend\components\ExcelGrid;
use rmrevin\yii\fontawesome\FA;
use Yii;
use my\test\common\models\FileModel;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\db\Migration;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * Class ExcelController
 *
 * @package my\test\frontend\controllers
 *
 * @see  https://github.com/codemix/yii2-excelexport  codemix组织出品
 *
 * @todo 导出一个excel时需要生成一个模板文件 那么可以伪造一行记录  此时可以考虑用facker
 *
 */
class ExcelController extends Controller
{

    public function actionIndex()
    {
        /** @var Connection $db */
        $db = \Yii::$app->sqliteDb;
        $schema = $db->getSchema();
        $tables = $schema->getTableNames();

        /** @var AttachmentMigration $mig */
        $mig = \Yii::createObject([
            'class' => AttachmentMigration::className(),
        ]);
        if ($schema->getTableSchema($mig->tableName) === null) {
            if ($mig->up()) {
                echo 'table created success: ', $mig->tableName, PHP_EOL;
            }
        }
        die(__METHOD__);
    }

    public function actionExport()
    {
        /*
        \moonland\phpexcel\Excel::widget([
            'models' => $allModels,
            'mode' => 'export', //default value as 'export'
            'columns' => ['column1','column2','column3'], //without header working, because the header will be get label from attribute label.
            'headers' => ['column1' => 'Header Column 1','column2' => 'Header Column 2', 'column3' => 'Header Column 3'],
        ]);
        */
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function actionExport2()
    {
        $file = \Yii::createObject([
            // 'class' => 'codemix\excelexport\ExcelFile',
            'class' => ExcelFile::className(), // 'codemix\excelexport\ExcelFile',

            // TODO 这个坑mime不识别 不要用excel5格式  好像还不是这个问题可能是libreoffice wps打开编辑后保存的问题 office兼容性！
            //  'writerClass' => '\PHPExcel_Writer_Excel5', // Override default of `\PHPExcel_Writer_Excel2007`

            'sheets' => [

                'MyAttachment' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',

                    'query' => MyAttachment::find(),  // User::find()->where(['active' => true]),

                    // If not specified, all attributes from `User::attributes()` are used
                    'attributes' => null,  // NOTE 是null才使用ActiveRecord的attributes
                    //[

//                        'id',
//                        'name',
//                        'email',
//                        'team.name',    // Related attribute
//                        'created_at',

                    // ],

                    // If not specified, the label from the respective record is used.
                    // You can also override single titles, like here for the above `team.name`
                    'titles' => [
                        // 'D' => 'Team Name',
                    ],
                ],

            ],
        ]);
        $file->send('demo.xlsx');
        Yii::$app->end();
    }

    public function actionExport3()
    {

        $query = MyAttachment::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // die(__METHOD__) ;
        $content =  ExcelGrid::widget([
            'dataProvider' => $dataProvider,
            'properties' => []
        ]);

        $this->renderContent($content) ;
    }

    public function actionExport4()
    {
        /*
        $query = MyAttachment::find();
        $dataProvider = new ArrayDataProvider([
            'allModels' =>[ new MyAttachment2() ], // 空对象！
        ]);
        ExcelGrid::widget([
            'dataProvider' => $dataProvider,
            'properties' => []
        ]);
        */
        /*
        $emptyModel = new MyAttachment2() ;
        $content = \moonland\phpexcel\Excel::widget([
            'models' => MyAttachment2::findAll([]) ,  // [ $emptyModel ],
            'mode' => 'export', //default value as 'export'
             'columns' => $emptyModel->attributes(), // ['column1','column2','column3'], //without header working, because the header will be get label from attribute label.
              'headers' => $emptyModel->attributeLabels() ,  //['column1' => 'Header Column 1','column2' => 'Header Column 2', 'column3' => 'Header Column 3'],
        ]);

        // Yii::$app->end() ;
        return $this->renderContent($content) ;
        */
        die(__METHOD__) ;
    }

    /**
     * 导入
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionImport()
    {

        $model = new FileModel();
        /*
        if ($model->load(\Yii::$app->request->post())) {
             print_r($_FILES) ;

             die(__METHOD__) ;
        } else {
            return $this->render('import', [
                'model' => $model,
            ]);
        }*/

        if (Yii::$app->request->isPost) {

            $results = [];

            $model->file = UploadedFile::getInstance($model, 'file');

            // NOTE 文件验证有问题 只要经过修改 Mime就无法识别 很奇怪
            if ($model->file != null && $model->validate()) {
                //  $model->file->saveAs(‘uploads/’ . $model->file->baseName . ‘.’ . $model->file->extension);

                // @see https://flysystem.thephpleague.com/docs/guides/uploads/
                /*

                 if ($file->error === UPLOAD_ERR_OK) {
                    $stream = fopen($file->tempName, 'r+');
                    $filesystem->writeStream('uploads/'.$file->name, $stream);
                    fclose($stream);
                }
                 */


                /** @var UploadedFile $uploadedFile */
                $uploadedFile = $model->file;
                $fileName = $uploadedFile->tempName;

                $data = \moonland\phpexcel\Excel::widget([
                    'mode' => 'import',
                    'fileName' => $fileName,
                    'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
                    'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
                    'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                ]);
                // print_r($data);
                /*
                $results[] = [
                  'original-excel-data'=>print_r($data, true),
                ];
                */
                $results['original-excel-data'] = VarDumper::dumpAsString($data, 10, true);  // print_r($data, true) ;

                if (is_array($data) && !empty($data)) {

                    $attributesLabels = (new MyAttachment())->attributeLabels();
                    $labelAttributes = array_flip($attributesLabels);

                    // TODO 钩子！ 抛事件！
                    // 下面这个代码块用来获取某个列 可以处理关联表的情况
                    {
                        $creatorNames = ArrayHelper::getColumn($data, '创建人', false);
                        // 去重
                        $creatorNames = array_unique($creatorNames);

                        $results[] = 'creator_name:  ' . VarDumper::dumpAsString($creatorNames);
                    }


                    /**
                     * 循环处理每行数据 如果想做成通用处理流程 此处需要留钩子 可以参考GridView beforeRow afterRow 方法
                     */
                    foreach ($data as $idx => $row) {

                        $attributes = [];
                        foreach ($row as $col => $val) {
                            // $attr = $labelAttributes[$col] ;
                            if (isset($labelAttributes[$col])) {
                                $attr = $labelAttributes[$col];
                                // 注意如果是关联表情况 那么还需要处理关联映射问题  比如 category_name => category_id
                                $attributes[$attr] = $val;
                            } else {
                                // 有额外列或者非法列存在
                            }

                        }

                        $arModel = new MyAttachment();
                        // $arModel->attributes = $attributes ;
                        // BEFORE_MODEL_LOAD_ATTRIBUTES
                        // TODO 把model 抛出去  使得外部可以监听模型方法  attributes也可以抛出去
                        if ($arModel->load($attributes, '')) {
                            if ($arModel->save()) {
                                $results[] = "import succeed: id is {$arModel->primaryKey}";
                            }
                        }

                    }

                }
                // 导入数据库 对应表的操作

                /**
                 * [2] => Array
                 * (
                 * [管理员ID] => 2
                 * [用户账号] => admin
                 * [密码] =>
                 * [头像] =>
                 * [邮箱] => admin@admin.com
                 * [角色] => admin
                 * [状态] => 启用
                 * [创建时间] => 2019-03-03 14:10:54
                 * [创建用户] => admin
                 * [修改时间] => 2019-03-28 07:43:40
                 * )
                 * [3] => Array
                 * (
                 * [管理员ID] => 1
                 * [用户账号] => super
                 * [密码] =>
                 * [头像] => /uploads/avatars/5c9830fb378d3.jpg
                 * [邮箱] => super@admin.com
                 * [角色] => admin
                 * [状态] => 启用
                 * [创建时间] => 2019-03-03 14:10:54
                 * [创建用户] => super
                 * [修改时间] => 2019-03-25 09:38:18
                 * )
                 */
                /**
                 * 可以看到 数据记录是 label => value 形式
                 *
                 * 而我们如果要创建一个AR 基本形式是：
                 * $model = new MyAr() ;
                 * $model->attributes = [  attr => var1 , attr2 => val2 ... ]
                 *
                 * if($model->validate()){  $model->save(false) ;  }
                 *
                 * 可以看出关键点在把 label=>value 转换为 attr=>value 即可
                 *
                 */


                // 上传处理
                /**
                 *         'fs' => [
                 * 'class' => 'creocoder\flysystem\LocalFilesystem',
                 * 'path' => '@webroot/files',
                 * ],
                 */
                // 临时测试  不用配置到全局去
                // @see https://github.com/creocoder/yii2-flysystem
                Yii::$app->set(
                    'fs',
                    [
                        'class' => 'creocoder\flysystem\LocalFilesystem',
                        // 'path' => '@webroot/files',
                        'path' => '@webroot/uploads',
                    ]
                );
                /** @var LocalFilesystem $fs */
                $fs = Yii::$app->fs;
                $relateveFilePath = genDirName()
                    . DIRECTORY_SEPARATOR
                    . genRandomString(15)
                    . '.' . $uploadedFile->getExtension();

                // TODO 有个循环检测逻辑 不断判断文件名是否存在 如果存在不断生新的随机名 直到不存在

                $stream = fopen($uploadedFile->tempName, 'r+');
                $fs->write($relateveFilePath, $stream);
                fclose($stream);

                $mimetype = $fs->getMimetype($relateveFilePath);


                return $this->renderContent(implode('</br>', $results));
                // die(__METHOD__);
            }


        }

        return $this->render('import', ['model' => $model,]);


    }

    public function actionUploads()
    {
        $model = new MyAttachment2();

        // 一定要设置场景！
        $model->setScenario('insert') ;

        if (\Yii::$app->request->isPost
            && $model->load($_POST) ) {

            // validate 前触发赋值
            if ($model->validate()) {
                //   VarDumper::dump($model->files );
                //die('validate passed!') ;
                 // print_r($model->files) ;
                // die("success");
                // save前触发上传 此时有个机会来监听处理上传的文件路径们

                $counter = 0 ;
                // 实际这个函数会被重复调用两次
                $model->on(UploadBehavior::EVENT_AFTER_UPLOAD , function (MultipleUploadEvent $event){
                     if($event->isBeforeSave){
                         $event->model->path = json_encode($event->uploadedPaths) ;

                         $uploadedPathMapping = [] ;
                         foreach($event->uploadedPaths as $uploadedPath){
                             $uploadedPathMapping[$uploadedPath] = $event->model->getUploadedFileByPath($uploadedPath)->name ;
                         }



                         \Yii::$app->getSession()->setFlash('warning', '保存之前 多文件存储：'.VarDumper::dumpAsString([
                                'model->path' => $event->model->path ,
                                 'uploadedPathMapping'=>$uploadedPathMapping ,
                             ]));
                     }else{
                         // 存储后的处理 比如存储到扩展附件表去
                         \Yii::$app->getSession()->setFlash('info',
                             '保存之后的模型id:'.$event->model->primaryKey);
                     }
                });

                // save 时触发上传了
                $model->save(false) ;

                // \Yii::$app->getSession()->setFlash('error',   'noty1');
               // \Yii::$app->getSession()->setFlash('info',    'noty2');
                 \Yii::$app->getSession()->setFlash('success', '上传成功啦！');
                // \Yii::$app->getSession()->setFlash('warning', 'noty4');
            }
            /*
            else{
                print_r($model->getErrors() );
                die(__METHOD__) ;
            }
            */
        }

        return $this->render('uploads', [
            'model' => $model
        ]);
    }

}

/**
 * @return false|string
 */
function genDirName()
{
    $dirTemplate = '{Y}/{m}/{d}';
    $dirTemplate = str_replace(['{', '}'], '', $dirTemplate);
    // $dirTemplate = str_replace('/',DIRECTORY_SEPARATOR , $dirTemplate);
    $newDir = date($dirTemplate);
    return $newDir;
}

/**
 * @param int $length
 * @return string
 */
function genRandomString($length = 10)
{
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));
    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }
    return $key;
}

/**
 * Class AttachmentMigration
 * @package my\test\frontend\controllers
 */
class AttachmentMigration extends Migration
{

    public $db = 'sqliteDb';

    public $tableName = 'attachment';

    public function up()
    {
        // $this->down() ;

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),

            'name' => $this->string()->notNull(),//->comment('附件名称'),
            'desc' => $this->string()->defaultValue(''),//->comment('描述'),
            'keywords' => $this->string()->defaultValue(''),//->comment('关键字'),

            'path' => $this->string(),//->comment('存储路径'),

            'created_at' => $this->integer()->unsigned(),//->comment('创建时间'),
            'updated_at' => $this->integer()->unsigned(),//->comment('更新时间'),

            'created_by' => $this->integer()->unsigned(),//->comment('创建者id'),
            'updated_by' => $this->integer()->unsigned(),//->comment('更新者id'),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}

/**
 * TODO 按理AR 可以生成的 除了特殊情况需要手动创建 里面的属性可以来自表注释 可以用db schema来提取注释生出label 可以参考gii
 *
 * Class MyAttachment
 * @package my\test\frontend\controllers
 */
class MyAttachment extends ActiveRecord
{
    public static function getDb()
    {
        return \Yii::$app->sqliteDb;
    }

    /** @inheritdoc */
    public static function tableName()
    {
        $mig = new AttachmentMigration();
        return $mig->tableName;
        // return '{{%social_account}}';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'desc', 'keywords', 'path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'desc' => '描述',
            'keywords' => '关键字',
            'path' => '存储路径',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'created_by' => '创建人',
            'updated_by' => '更新者',
        ];
        /*
        return [
            'id' => 'ID',
            'name' => 'Name',
            'desc' => 'Desc',
            'keywords' => 'Keywords',
            'path' => 'Path',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
        */
    }

}

class MyAttachment2 extends MyAttachment
{

    /** @var UploadedFile[] */
    public $files ;
    /**
     * @inheritdoc
     */
    public function rules()
    {

        return ArrayHelper::merge(
            parent::rules(),
            [
                ['files', 'file',
                    //'extensions' => 'doc, docx, pdf',
                    'maxFiles' => 4,'skipOnEmpty' => false,
                    'on' => ['insert', 'update']],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::class,
                'attribute' => 'files',
                'multiple'=> true ,
                'scenarios' => ['insert', 'update'],

            ],
        ];
    }

}