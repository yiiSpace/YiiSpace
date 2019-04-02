<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/3/31
 * Time: 19:48
 *
 * @see https://github.com/mohorev/yii2-upload-behavior/blob/master/src/UploadBehavior.php
 */

namespace common\behaviors;


use Closure;
use creocoder\flysystem\LocalFilesystem;
use Yii;
use yii\base\Behavior;
use yii\base\Event;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

/**
 * UploadBehavior automatically uploads file and fills the specified attribute
 * with a value of the name of the uploaded file.
 *
 * To use UploadBehavior, insert the following code to your ActiveRecord class:
 *
 * ```php
 * use mohorev\file\UploadBehavior;
 *
 * function behaviors()
 * {
 *     return [
 *         [
 *             'class' => UploadBehavior::class,
 *             'attribute' => 'file',
 *             'scenarios' => ['insert', 'update'],
 *             'path' => '@webroot/upload/{id}',
 *             'url' => '@web/upload/{id}',
 *         ],
 *     ];
 * }
 * ```
 * @see https://github.com/mohorev/yii2-upload-behavior/blob/master/src/UploadBehavior.php
 *
 * @author Alexander Mohorev <dev.mohorev@gmail.com>
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 *
 * ------------------------------------------------------------------------------------  +|
 * /                                                                       \
 *      原始实现上传时机是在afterSave中进行的 这样ar存储的时候实际上存的是已经基本固化的后半段路径
 *      真正上传的时候 通过动态计算目录部分（可以含有已经存储的一些属性占位）再加上后半段路径（可以通过UploadFile获取）
 *      这样合起来组成了整个文件路径  dynamicDirPart /  firmedFilePath . ext
 *
 * \                                                                       /
 * ------------------------------------------------------------------------------------  +|
 *
 */
class UploadBehavior extends Behavior
{
    /**
     * @event Event an event that is triggered after a file is uploaded.
     */
    const EVENT_AFTER_UPLOAD = 'afterUpload';

    /**
     * @event Event an event that is triggered after a file is uploaded.
     */
    // const EVENT_BEFORE_AR_SAVE = 'beforeARSave';

    /**
     * @event Event an event that is triggered after a file is uploaded.
     */
    // const EVENT_AFTER_AR_SAVE = 'afterARSave';


    /**
     * @var string the attribute which holds the attachment.
     */
    public $attribute;
    /**
     * @var array the scenarios in which the behavior will be triggered
     */
    public $scenarios = [];
    /**
     * @var string the base path or path alias to the directory in which to save files.
     */
    // public $path;
    /**
     * @var string the base URL or path alias for this file
     */
    // public $url;
    /**
     * @var bool Getting file instance by name
     */
    public $instanceByName = false;
    /**
     * @var boolean|callable generate a new unique name for the file
     * set true or anonymous function takes the old filename and returns a new name.
     * @see self::generateFileName()
     */
    public $generateNewName = true;
    /**
     * @var boolean If `true` current attribute file will be deleted
     */
    public $unlinkOnSave = true;
    /**
     * @var boolean If `true` current attribute file will be deleted after model deletion.
     */
    public $unlinkOnDelete = true;
    /**
     * @var boolean $deleteTempFile whether to delete the temporary file after saving.
     */
    public $deleteTempFile = true;

    /**
     * @var UploadedFile the uploaded file instance.
     */
    private $_file;

    /**
     * @var LocalFilesystem
     */
    public $fs;


    /**
     * @var bool
     */
    public $multiple = false;
    /**
     * @var UploadedFile[] the uploaded files instances.
     */
    private $_files;

    /**
     * @var array
     */
    private static $_uploadedFiles = [];


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->attribute === null) {
            throw new InvalidConfigException('The "attribute" property must be set.');
        }
        /*
        if ($this->path === null) {
            throw new InvalidConfigException('The "path" property must be set.');
        }
        if ($this->url === null) {
            throw new InvalidConfigException('The "url" property must be set.');
        }
        */
        if (empty($this->fs)) {
            $this->fs = Yii::$app->get('fs'); // TODO 后期改为可配置 先写死

            if ($this->fs == null) {
                throw  new InvalidConfigException("you should config the fs component as a LocalFilesystem instance");
            }
        }

    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    /**
     * This method is invoked before validation starts.
     */
    public function beforeValidate()
    {
        /** @var BaseActiveRecord $model */
        $model = $this->owner;
        if (in_array($model->scenario, $this->scenarios)) {
            // 多文件处理
            if ($this->multiple === true) {
                // 防止验证前手动进行了赋值
                // TODO 未检测是不是每个元素都是UploadedFile 的实例
                /**
                 *   假设有这样的方法  any all  其中都是一些判断如果任何一个方法的执行结果返回false|true 那么总体结果是？
                 *   短路操作  或者 跟电路那样并联 串联一样  一通全通（并联）  一断全断（串联）
                 *   用这样的操作 就可以检测数组是不是某个类型的 比如 UploadedFile[]  如果数组元素中有一个不是那么整体失败
                 *   ArrayHelper::All($files , function($file){   return $file instanceof UploadedFile ; }   )
                 */


                /** @var bool $isUploadedFiles */
                $isUploadedFiles = function ($files = []) {
                    return  array_reduce($files, function ($pre, $current) {
                        return $pre && ($current instanceof UploadedFile);
                    }, true);
                };

                if (($files = $model->getAttribute($this->attribute)) && is_array($files) && $isUploadedFiles($files)) {
                    $this->_files = $files;
                } else {
                    if ($this->instanceByName === true) {
                        $this->_files = UploadedFile::getInstancesByName($this->attribute);
                    } else {
                        $this->_files = UploadedFile::getInstances($model, $this->attribute);
                    }
                }

                if ($isUploadedFiles($this->_files)) {
                    // $this->_file->name = $this->getFileName($this->_file); // 名称净化 对于数组形式需要遍历来设置的！
                    // $model->setAttribute($this->attribute, $this->_files);
                    // NOTE 允许非db字段的保存
                    $model->{$this->attribute} = $this->_files;

                }
            } // 单文件处理
            else {
                if (($file = $model->getAttribute($this->attribute)) instanceof UploadedFile) {
                    $this->_file = $file;
                } else {
                    if ($this->instanceByName === true) {
                        $this->_file = UploadedFile::getInstanceByName($this->attribute);
                    } else {
                        $this->_file = UploadedFile::getInstance($model, $this->attribute);
                    }
                }
                if ($this->_file instanceof UploadedFile) {
                    // 这个是文件名重写 关键点就在这里 先生成了文件目标名 db成功后才执行真正的上传
                    //  ！串改了原始文件名称 后期不想使用此名称了！
                    //  $this->_file->name = $this->getFileName($this->_file);
                    $model->setAttribute($this->attribute, $this->_file);
                }
            }
        }
    }

    /**
     * This method is called at the beginning of inserting or updating a record.
     */
    public function beforeSave()
    {
        if ($this->multiple == true) {
            /** @var BaseActiveRecord $model */
            $model = $this->owner;
            if (in_array($model->scenario, $this->scenarios)) {

                /** @var LocalFilesystem $fs */
                // $fs = $this->fs;

                // TODO 这是AR存储前的操作  对于多文件上传一个可能是 遍历上传所有文件 获取文件路径数组
                // 可以存储成一个 json串 这里通过事件留钩子
                $uploadedPaths = [];
                foreach ($this->_files as $uploadedFile) {
                    $uploadedPaths[] = $this->uploadFile($uploadedFile);
                }

                $this->beforeARSave($uploadedPaths);

                $self = $this;
                if ($model->getIsNewRecord()) {
                    $model->on(ActiveRecord::EVENT_AFTER_INSERT, function () use ($self, $uploadedPaths) {
                        $self->afterARSave($uploadedPaths);
                    });
                } else {
                    $model->on(ActiveRecord::EVENT_AFTER_UPDATE, function () use ($self, $uploadedPaths) {
                        $self->afterARSave($uploadedPaths);
                    });
                }

            }

        } else {
            $this->handleSingleUpload();
        }

    }

    /**
     * @param string $dirTemplate
     * @return false|string
     */
    protected function genDirName($dirTemplate = '{Y}/{m}/{d}')
    {

        $dirTemplate = str_replace(['{', '}'], '', $dirTemplate);
        // $dirTemplate = str_replace('/',DIRECTORY_SEPARATOR , $dirTemplate);
        $newDir = date($dirTemplate);

        return $newDir;

    }

    /**
     * @param string $uploadedPath
     * @return UploadedFile
     */
    public function getUploadedFileByPath($uploadedPath = '')
    {
        return self::$_uploadedFiles[$uploadedPath];
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return string
     */
    protected function uploadFile(UploadedFile $uploadedFile)
    {
        /** @var LocalFilesystem $fs */
        $fs = $this->fs;

        $relativeFilePath = $this->generateFileName($uploadedFile);

        // TODO 有个循环检测逻辑 不断判断文件名是否存在 如果存在不断生新的随机名 直到不存在

        $relativeFilePath = $this->genDirName() . DIRECTORY_SEPARATOR . $relativeFilePath;

        $stream = fopen($uploadedFile->tempName, 'r+');
        $fs->write($relativeFilePath, $stream);
        fclose($stream);

        // 存储到静态变量 可以供后期获取原始上传文件
        self::$_uploadedFiles[$relativeFilePath] = $uploadedFile;

        return $relativeFilePath;
    }

    protected function handleSingleUpload()
    {
        /** @var BaseActiveRecord $model */
        $model = $this->owner;
        if (in_array($model->scenario, $this->scenarios)) {
            if ($this->_file instanceof UploadedFile) {

                $relativeFilePath = $this->uploadFile($this->_file);
                // 存储到db
                /*
                 if (!$model->getIsNewRecord() && $model->isAttributeChanged($this->attribute)) {
                     if ($this->unlinkOnSave === true) {
                         $this->delete($this->attribute, true);
                     }
                 }
                 $model->setAttribute($this->attribute, $this->_file->name);
                */

                /**
                 *
                 */
                if (!$model->getIsNewRecord() && $model->isAttributeChanged($this->attribute)) {
                    if ($this->unlinkOnSave === true) {

                        $oldPath = $model->getOldAttribute($this->attribute);
                        $fs = $this->fs;
                        $model->on(ActiveRecord::EVENT_AFTER_UPDATE, function () use ($fs, $oldPath) {
                            if ($fs->has($oldPath)) $fs->delete($oldPath);
                            // NOTE 闭包中的函数 最好是状态无关的 不然事件如果延迟执行属性是会随对象状态变的
                        });
                        // $this->delete($this->attribute, true);
                    }
                }

                $model->setAttribute($this->attribute, $relativeFilePath);


            } else {
                // 不让乱设置属性！ 不能命令行调用？ 只能通过文件上传来变动该属性！
                // Protect attribute
                unset($model->{$this->attribute});
            }
        } else {
            // 没有上传文件 但是此字段也被变更掉了
            if (!$model->getIsNewRecord() && $model->isAttributeChanged($this->attribute)) {
                if ($this->unlinkOnSave === true) {
                    $this->delete($this->attribute, true);
                }
            }
        }
    }

    /**
     * 主记录保存以后才执行上传  我们的逻辑经常是保存前就上传然后才有文件路径
     *
     * This method is called at the end of inserting or updating a record.
     * @throws \yii\base\InvalidArgumentException
     */
    public function afterSave()
    {
        /*
        if ($this->_file instanceof UploadedFile) {
            $path = $this->getUploadPath($this->attribute);
            if (is_string($path) && FileHelper::createDirectory(dirname($path))) {
                $this->save($this->_file, $path);
                $this->afterUpload();
            } else {
                throw new InvalidArgumentException(
                    "Directory specified in 'path' attribute doesn't exist or cannot be created."
                );
            }
        }
        */
    }

    /**
     * This method is invoked after deleting a record.
     */
    public function afterDelete()
    {
        $attribute = $this->attribute;
        if ($this->unlinkOnDelete && $attribute) {
            $this->delete($attribute);
        }
    }

    /**
     * 未用到
     *
     * @deprecated  暂时不推荐用
     *
     * Returns file path for the attribute.
     * @param string $attribute
     * @param boolean $old
     * @return string|null the file path.
     */
    public function getUploadPath($attribute, $old = false)
    {
        /** @var BaseActiveRecord $model */
        $model = $this->owner;
        $path = $this->resolvePath($this->path);
        $fileName = ($old === true) ? $model->getOldAttribute($attribute) : $model->$attribute;

        return $fileName ? Yii::getAlias($path . '/' . $fileName) : null;
    }

    /**
     * 暂时没用到！
     *
     * @deprecated  暂时不推荐用
     *
     * Returns file url for the attribute.
     * @param string $attribute
     * @return string|null
     */
    public function getUploadUrl($attribute)
    {
        /** @var BaseActiveRecord $model */
        $model = $this->owner;
        $url = $this->resolvePath($this->url);
        $fileName = $model->getOldAttribute($attribute);

        return $fileName ? Yii::getAlias($url . '/' . $fileName) : null;
    }

    /**
     * @TODO 这个方法应该放开 有的时候需要获取上传出文件的详细信息 比如：原名 不能给遮盖了
     *
     * Returns the UploadedFile instance.
     * @return UploadedFile
     */
    public function getUploadedFile()
    {
        return $this->_file;
    }

    /**
     * 未用到
     *
     * Replaces all placeholders in path variable with corresponding values.
     */
    protected function resolvePath($path)
    {
        /** @var BaseActiveRecord $model */
        $model = $this->owner;
        return preg_replace_callback('/{([^}]+)}/', function ($matches) use ($model) {
            $name = $matches[1];
            $attribute = ArrayHelper::getValue($model, $name);
            if (is_string($attribute) || is_numeric($attribute)) {
                return $attribute;
            } else {
                return $matches[0];
            }
        }, $path);
    }

    /**
     * 暂时没用到
     *
     * Saves the uploaded file.
     * @param UploadedFile $file the uploaded file instance
     * @param string $path the file path used to save the uploaded file
     * @return boolean true whether the file is saved successfully
     */
    protected function save($file, $path)
    {
        return $file->saveAs($path, $this->deleteTempFile);
    }

    /**
     * Deletes old file.
     * @param string $attribute
     * @param boolean $old
     */
    protected function delete($attribute, $old = false)
    {
        /*
        $path = $this->getUploadPath($attribute, $old);
        if (is_file($path)) {
            unlink($path);
        }
        */
        /** @var BaseActiveRecord $model */
        $model = $this->owner;
        $path = $old == true ? $model->getOldAttribute($attribute) : $model->{$attribute}; // $model->getAttribute($attribute) ;

        if ($this->fs->has($path)) {
            $this->fs->delete($path);
        }

    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    protected function getFileName($file)
    {
        if ($this->generateNewName) {
            return $this->generateNewName instanceof Closure
                ? call_user_func($this->generateNewName, $file)
                : $this->generateFileName($file);
        } else {
            return $this->sanitize($file->name);
        }
    }

    /**
     * Replaces characters in strings that are illegal/unsafe for filename.
     *
     * #my*  unsaf<e>&file:name?".png
     *
     * @param string $filename the source filename to be "sanitized"
     * @return boolean string the sanitized filename
     */
    public static function sanitize($filename)
    {
        return str_replace([' ', '"', '\'', '&', '/', '\\', '?', '#'], '-', $filename);
    }

    /**
     * Generates random filename.
     * @param UploadedFile $file
     * @return string
     */
    protected function generateFileName($file)
    {
        return uniqid() . '.' . $file->extension;
    }

    /**
     * This method is invoked after uploading a file.
     * The default implementation raises the [[EVENT_AFTER_UPLOAD]] event.
     * You may override this method to do postprocessing after the file is uploaded.
     * Make sure you call the parent implementation so that the event is raised properly.
     */
    protected function afterUpload()
    {
        // NOTE event triggered on owner not $this
        $this->owner->trigger(self::EVENT_AFTER_UPLOAD);
    }

    /**
     * @param $files
     */
    protected function beforeARSave($files)
    {
        $event = new MultipleUploadEvent();
        $event->model = $this->owner;
        $event->attribute = $this->attribute;
        $event->isBeforeSave = true;
        $event->uploadedPaths = $files;
        // 哇佳佳 行为不可用触发自己的事件呢！
        $this->owner->trigger(self::EVENT_AFTER_UPLOAD, $event);
    }

    /**
     * TODO 两段代码太相似了 写个帮助方法减轻下 newMultipleUploadEvent($isBeforeSave, uploadedPaths)
     * @param $files
     */
    protected function afterARSave($files)
    {
        $event = new MultipleUploadEvent();
        $event->model = $this->owner;
        $event->attribute = $this->attribute;
        $event->isBeforeSave = false;
        $event->uploadedPaths = $files;
        // 哇佳佳 行为不可用触发自己的事件呢！
        $this->owner->trigger(self::EVENT_AFTER_UPLOAD, $event);
    }


}

/**
 * 事件就是用来传递信息的 里面的属性就是你想传递的payload负载
 *
 * Class MultipleUploadEvent
 * @package common\behaviors
 */
class MultipleUploadEvent extends Event
{

    /** @var  ActiveRecord|BaseActiveRecord|UploadBehavior */
    public $model;

    /**
     * @var string the attribute which holds the attachment.
     */
    public $attribute;

    /**
     * @var bool whether happened before ActiveRecord save ,else happened afterSave
     */
    public $isBeforeSave = true;

    /**
     * @var array
     */
    public $uploadedPaths = [];

}