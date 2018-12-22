<?php

namespace my\content\backend\controllers;

use my\content\common\models\Album;
use year\api\base\ValidationException;

/**
* This is the class for controller "AlbumController".
*/
class AlbumController extends \my\content\backend\controllers\base\AlbumController
{

    public function actionApiList()
    {
        $albums = Album::forPhotoDropDownSelection() ;
        $results = [] ;
        foreach ($albums as $id=>$name){
            $results[] = [
                'id'=>$id,
                'name'=>$name,
            ];
        }

        return $this->asJson(
            $results
        );
    }
}
