<?php
/**
 * User: yiqing
 * Date: 14-9-19
 * Time: 上午11:25
 */

namespace year\upload\local;


use year\upload\local\urladapter\EvaThumber;
use year\upload\UploadStorageInterface;
use yii\base\Component;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\base\NotSupportedException;
use yii\web\UploadedFile;

/**
 *
 * Class UploadStorage
 * @package year\upload\local
 */
class UploadStorage extends Component implements UploadStorageInterface
{

    /**
     * @var \year\upload\local\UrlAdapter
     */
    public $urlAdapter = '\year\upload\local\urladapter\EvaThumber';

    /**
     * @return EvaThumber
     */
    public  function getUrlAdapter()
    {
        // TODO 做个静态缓存
        return \Yii::createObject([
            'class'=>$this->urlAdapter,
            'uploadStorage'=>$this ,
        ]);
    }

    /**
     * @var string
     *
     * Yii::GET
     *
     */
    public $basePath;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    public $baseDirName = 'uploads';
    /**
     * @var string
     */
    public $dirTemplate = '{Y}/{m}/{d}';

    /**
     * @param string $uploadedFile
     * @param bool $deleteTempFile
     * @return bool|string
     * @throws \yii\base\NotSupportedException
     */
    public function performUpload($uploadedFile = '', $deleteTempFile = true)
    {
        $basePath = $this->getBasePath();
        $uploadDir = $this->getUploadDir();
        $this->ensureDirPath($basePath, $uploadDir);

        $relativePath = $uploadDir . DIRECTORY_SEPARATOR . $this->genFileName() . '.' . $this->getExtension($uploadedFile);
        $savedPath = $basePath . DIRECTORY_SEPARATOR . $relativePath;

        $relativeUri = str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);

        if ($uploadedFile instanceof UploadedFile) {

            if ($uploadedFile->saveAs($savedPath, $deleteTempFile)) {
                return $relativeUri;
            } else {
                return false;
            }
        } elseif (is_string($uploadedFile)) {
            // throw new NotSupportedException('not support the local file copy ,pls manually do it !');
            if(is_file($uploadedFile)){
                 if($deleteTempFile == true){
                      if(!rename($uploadedFile,$savedPath)){
                          throw new Exception(" can not rename source  file :{$uploadedFile} to dist location: {$savedPath} ,pls check permission! ");
                      }
                 }else{
                     if(!copy($uploadedFile, $savedPath)){
                         throw new Exception(" can not copy source  file :{$uploadedFile} to dist location: {$savedPath} ,pls check permission! ");
                     }
                 }
                return $relativeUri ;
            }else{
                /*
                print_r($uploadedFile);
                die(__METHOD__);
                */
                throw new Exception(" not a file :{$uploadedFile}");
            }
        }
        /*
        else{
            throw new InvalidParamException('uploadedFile '.var_export($uploadedFile,true)) ;
        }
        */

    }

    /**
     * @param string $uploadedFile|yii\web\UploadedFile;
     * @return string
     */
    protected function getExtension($uploadedFile = ''){
        if($uploadedFile instanceof UploadedFile){
            return $uploadedFile->getExtension() ;
        }elseif(is_string($uploadedFile)){
            return strtolower(pathinfo($uploadedFile, PATHINFO_EXTENSION));
        }
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl = '')
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return bool|string
     */
    public function getBaseUrl()
    {
        if (empty($this->baseUrl)) {
            $this->baseUrl = \Yii::getAlias('@web');
        }
        return $this->baseUrl;

    }

    /**
     * @param string $fileId the file URI for identifying in this storage system
     * @return string|bool the accessible url for public
     *                      false means the file does not exist!
     */
    public function getPublicUrl($fileId = '')
    {

       return $this->getUrlAdapter()->getPublicUrl($fileId) ;
        //  return $this->getBaseUrl() . '/' . ltrim($fileId, '/');
    }

    /**
     * @return bool|string
     */
    public function getBasePath()
    {
        $basePath = empty($this->basePath) ? \Yii::getAlias('@webroot') : $this->basePath;
        return $basePath;
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function getUploadDir()
    {
        $baseDir = $this->baseDirName;
        $dirTemplate = str_replace(['{', '}'], '', $this->dirTemplate);
        // $dirTemplate = str_replace('/',DIRECTORY_SEPARATOR , $dirTemplate);
        $newDir = $baseDir . DIRECTORY_SEPARATOR . date($dirTemplate);
        return $newDir;
    }

    /**
     * FIXME 或许不必检测basePath 是可写的？
     *
     * @param string $basePath
     * @param string $dir
     * @throws \Exception
     */
    protected function ensureDirPath($basePath = '', $dir = '')
    {
        $newDir = $basePath . DIRECTORY_SEPARATOR . $dir;
        /*
        if (!file_exists($newDir) && is_writable($basePath)) {
           // if (mkdir($newDir, 0755, true) == false) {
            if (mkdir($newDir, 0777, true) == false) {
                throw new \Exception(sprintf('dir < %s > can not be created ! please check your permission !', $newDir));
            }
        }
        */
        if ( is_writable($basePath)) {
            if(! file_exists($newDir) ){
                // if (mkdir($newDir, 0755, true) == false) {
                if (mkdir($newDir, 0777, true) == false) {
                    throw new \Exception(sprintf('dir < %s > can not be created ! please check your permission !', $newDir));
                }
            }
        }
        else{
            throw new \Exception(sprintf('dir < %s > is not writable !', $basePath));
        }
    }

    /**
     * @return string
     */
    protected function genFileName()
    {
        /*
        $filename = '';
        while (true) {
            $filename = uniqid('MyApp', true) . '.pdf';
            if (!file_exists(sys_get_temp_dir() . $filename)) break;
        }
        */
        $uid = 0;
        $moduleId = 'app';
        if (\Yii::$app instanceof \yii\web\Application) {
            $uid = \Yii::$app->user->getId();
            $controller = \Yii::$app->controller;
            $module = $controller->module;
            $moduleId = $moduleId == null ? : $module->id;
        }
        $prefix = $moduleId . '_' . $uid . '_';

        return uniqid($prefix) . $this->randomString(8);
        /*
          $m=microtime(true);
          return  $prefix. sprintf("%8x%05x\n",floor($m),($m-floor($m))*1000000);
        */
    }

    /**
     * @param int $length
     * @return string
     */
    protected function randomString($length = 10)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        return $key;
    }

    /**
     * @param $imageUrI the original image uri
     * @param $height
     * @param int $width
     * @param array $extraConfig such as image quality ,water mark image ...
     * @return string the generated thumbnail image url.
     */
    public function getThumbUrl($imageUrI, $height, $width = 0, $extraConfig = [])
    {
          return $this->getUrlAdapter()->getThumbUrl($imageUrI,$height,$width,$extraConfig) ;
        /*
        $thumbUrlHandlerRoute = 'uploads/thumbs/';
        if ($width == 0) {
            $width = $height;
        }

        $suffix = pathinfo($imageUrI, PATHINFO_EXTENSION);
        if(strpos($imageUrI,$thumbUrlHandlerRoute) === false){
           $imageUrI =  str_replace('uploads/',$thumbUrlHandlerRoute,$imageUrI);
        }
        //$thumbUrl = $thumbUrlHandlerRoute .'/'.ltrim($sourceImgUrl)."_{$height}x{$width}.{$suffix}";
        return $this->getPublicUrl($imageUrI) . "_{$height}x{$width}.{$suffix}";
        */
    }


    /**
     * @param string $fileId
     * @return bool|mixed
     */
    public function deleteFile($fileId=''){
        // $filePath = $this->getBasePath() .DIRECTORY_SEPARATOR .str_replace( '/',DIRECTORY_SEPARATOR, $fileId);  ;
        $filePath = $this->getBasePath() .DIRECTORY_SEPARATOR .str_replace( '/',DIRECTORY_SEPARATOR, $fileId);  ;
        if(is_file($filePath)){
            return unlink($filePath) ;
        }
    }

    /**
     * @param string $fileId
     * @return string
     */
    public function getFilePath($fileId=''){
        $filePath = $this->getBasePath() .DIRECTORY_SEPARATOR .str_replace( '/',DIRECTORY_SEPARATOR, $fileId);  ;
        return $filePath ;
    }
}