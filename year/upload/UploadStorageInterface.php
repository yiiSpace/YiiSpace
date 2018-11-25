<?php
/**
 * User: yiqing
 * Date: 14-9-19
 * Time: 上午11:11
 */

namespace year\upload;

/**
 * It is possible use more than one storage together in one system!
 *
 * Interface UploadStorageInterface
 *
 * @package year\upload
 */
interface UploadStorageInterface {

    /**
     * @param string|\yii\web\UploadedFile $uploadedFile
     *         when it is string , it represent a local file path .
     *
     * @param bool $deleteTempFile
     * @return string|bool
     *           fileUrI a file URI|ID for identified the uploaded file .
     *           false means the file upload failed!
     */
    public function performUpload($uploadedFile='',$deleteTempFile=true);

    /**
     * @param string $fileId the file URI for identifying in this storage system
     * @return string|bool the accessible url for public
     *                      false means the file does not exist!
     */
    public function getPublicUrl($fileId= '');


    /**
     * @param $imageUrI the original image uri
     * @param $height
     * @param int $width
     * @param array $extraConfig such as image quality ,water mark image ...
     * @return string the generated thumbnail image url.
     */
    public function getThumbUrl($imageUrI,$height,$width=0,$extraConfig=[]);

    /**
     * @param string $fileId
     * @return bool|mixed
     */
    public function deleteFile($fileId='');

    /**
     * 本地文件|网络文件  的地址
     *
     * @param string $fileId
     * @return string
     */
    public function getFilePath($fileId='') ;
} 