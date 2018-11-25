<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/8/13
 * Time: 23:39
 */

namespace year\upload\local;


use yii\base\Component;

abstract class UrlAdapter extends Component
{
    /**
     * @var UploadStorage
     */
    public $uploadStorage ;



    /**
     * @param string $fileId the file URI for identifying in this storage system
     * @return string|bool the accessible url for public
     *                      false means the file does not exist!
     */
    public function getPublicUrl($fileId = '')
    {
        return $this->uploadStorage->getBaseUrl() . '/' . ltrim($fileId, '/');
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

        $thumbUrlHandlerRoute = 'uploads/thumbs/';
        if ($width == 0) {
            $width = $height;
        }

        $suffix = pathinfo($imageUrI, PATHINFO_EXTENSION);
        if(strpos($imageUrI,$thumbUrlHandlerRoute) === false){
            $imageUrI =  str_replace('uploads/',$thumbUrlHandlerRoute,$imageUrI);
        }
        //$thumbUrl = $thumbUrlHandlerRoute .'/'.ltrim($sourceImgUrl)."_{$height}x{$width}.{$suffix}";
        return $this->uploadStorage->getPublicUrl($imageUrI) . "_{$height}x{$width}.{$suffix}";
    }
}