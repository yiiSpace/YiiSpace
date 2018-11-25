<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/8/13
 * Time: 23:48
 */

namespace year\upload\local\urladapter;


use year\upload\local\UrlAdapter;

class EvaThumber extends UrlAdapter
{

    /**
     * @param $imageUrI the original image uri
     * @param $height
     * @param int $width
     * @param array $extraConfig such as image quality ,water mark image ...
     * @return string the generated thumbnail image url.
     */
    public function getThumbUrl($imageUrI, $height, $width = 0, $extraConfig = [])
    {
        
        $thumbDir = 'thumb/d/';

        $modeParts = [] ;
        $modeParts[] = 'h_'.$height ;

        if ($width === 0) {
            $width = $height;
            $modeParts[] = 'w_'.$width ;
        }elseif($width === false){
            // ignore
        }else{
            $modeParts[] = 'w_'.$width ;
        }



        $modeStr = ','.implode(',',$modeParts);

        $suffix = pathinfo($imageUrI,PATHINFO_EXTENSION);
        $imageUrI = ltrim($imageUrI,'upload/') ;

        $imageUrI =  substr_replace($imageUrI,'',strpos($imageUrI,'.'.$suffix));
        $imageUrI = $imageUrI.$modeStr.'.'.$suffix ;
//       echo $this->uploadStorage->getPublicUrl().$thumbDir.$imageUrI;
//        die();
        return $this->uploadStorage->getPublicUrl().$thumbDir.$imageUrI ;




        /*
        if(strpos($imageUrI,$thumbUrlHandlerRoute) === false){
            $imageUrI =  str_replace('uploads/',$thumbUrlHandlerRoute,$imageUrI);
        }
        */
        //$thumbUrl = $thumbUrlHandlerRoute .'/'.ltrim($sourceImgUrl)."_{$height}x{$width}.{$suffix}";
        return $this->uploadStorage->getPublicUrl($imageUrI) . "_{$height}x{$width}.{$suffix}";
    }
}