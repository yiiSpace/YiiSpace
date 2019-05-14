<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/5/14
 * Time: 14:15
 */

namespace my\test\frontend\controllers;


use yii\web\Controller;

class ZipController extends Controller
{
    public function actionIndex()
    {
        $outputFilename = __DIR__.'/myzip.zip' ;
// create new archive
        $zipFile = new \PhpZip\ZipFile();
        try{
            $zipFile
                ->addFromString("zip/entry/filename", "Is file content") // add an entry from the string
               // ->addFile("/path/to/file", "data/tofile") // add an entry from the file
                ->addFile(__FILE__, "somefiles/tofile.php") // add an entry from the file
                ->addDir(__DIR__, "to/path/") // add files from the directory
                ->saveAsFile($outputFilename) // save the archive to a file
                ->close(); // close archive

            // open archive, extract, add files, set password and output to browser.
//            $zipFile
//                ->openFile($outputFilename) // open archive from file
//                ->extractTo($outputDirExtract) // extract files to the specified directory
//                ->deleteFromRegex('~^\.~') // delete all hidden (Unix) files
//                ->addFromString('dir/file.txt', 'Test file') // add a new entry from the string
//                ->setPassword('password') // set password for all entries
//                ->outputAsAttachment('library.jar'); // output to the browser without saving to a file
        }
        catch(\PhpZip\Exception\ZipException $e){
            // handle exception
            $zipFile->close();
            return $this->renderContent('error: '.$e->getMessage()) ;
        }
        // 报错！
//        finally{
//            $zipFile->close();
//        }

        $zipFile->close();

        return $this->renderContent('ok') ;
    }

}