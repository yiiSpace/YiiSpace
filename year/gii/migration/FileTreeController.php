<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/6/20
 * Time: 16:33
 */

namespace year\gii\migration;


use year\gii\migration\utils\fs;
use yii\web\Controller;

class FileTreeController extends Controller
{
    public function actionFs()
    {
//        return __FILE__ ;
        // copy from jstree-php-demo
        if(isset($_GET['operation'])) {
            // $fs = new fs(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'root' . DIRECTORY_SEPARATOR);
            // $fs = new fs(__DIR__ . DIRECTORY_SEPARATOR);

            $diskRoot = isset($_GET['diskRoot']) ? $_GET['diskRoot'] : '/' ;

            $fs = new fs($diskRoot /*. DIRECTORY_SEPARATOR*/);
            try {
                $rslt = null;
                switch($_GET['operation']) {
                    case 'get_node':
                        $node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
                        $rslt = $fs->lst($node, (isset($_GET['id']) && $_GET['id'] === '#'));
                        break;
                    case 'get_path':
                        $node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
                        //  $rslt = $fs->lst($node, (isset($_GET['id']) && $_GET['id'] === '#'));
                        $rslt = $fs->path($_GET['id'] );
                        break;
                    case "get_content":
                        $node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
                        $rslt = $fs->data($node);
                        break;
                    case 'create_node':
                        $node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
                        $rslt = $fs->create($node, isset($_GET['text']) ? $_GET['text'] : '', (!isset($_GET['type']) || $_GET['type'] !== 'file'));
                        break;
                    case 'rename_node':
                        $node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
                        $rslt = $fs->rename($node, isset($_GET['text']) ? $_GET['text'] : '');
                        break;
                    case 'delete_node':
                        $node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
                        $rslt = $fs->remove($node);
                        break;
                    case 'move_node':
                        $node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
                        $parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? $_GET['parent'] : '/';
                        $rslt = $fs->move($node, $parn);
                        break;
                    case 'copy_node':
                        $node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
                        $parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? $_GET['parent'] : '/';
                        $rslt = $fs->copy($node, $parn);
                        break;
                    default:
                        throw new Exception('Unsupported operation: ' . $_GET['operation']);
                        break;
                }
                // header('Content-Type: application/json; charset=utf-8');
                // echo json_encode($rslt);
                return $this->asJson($rslt) ;
            }
            catch (\Exception $e) {
                header($_SERVER["SERVER_PROTOCOL"] . ' 500 Server Error');
                header('Status:  500 Server Error');
                echo $e->getMessage();
            }
            die();
        }

    }

    /**
     * 获取系统的盘符
     *
     * @return array
     */
    protected  function  getDiskRoots()
    {
        $roots = [] ;
        // echo DIRECTORY_SEPARATOR=='\\'?'windows 服务器':'不是 widnows 服务器';
        // echo PATH_SEPARATOR==';'?'windows 服务器':'不是 widnows 服务器';
        /** @var bool $isWindows */
        $isWindows = strtoupper(substr(PHP_OS,0,3))==='WIN'? true:false;

        if($isWindows){
            exec("wmic LOGICALDISK get name",$dir);
            $dir =  array_filter($dir) ; // 去除空值
            array_shift($dir) ;
            // print_r($dir) ;
            $roots = $dir ;
        }else{
            // linux platform
            $roots[] = '/' ;
        }

       return $roots ;
    }

    public function actionIndex()
    {
        // return $this->renderContent( 'hi') ;


        ob_start();
        ob_implicit_flush(false);

        $root = '/' ;
       // return  $this->renderContent('hello');

        //
// jQuery File Tree PHP Connector
//
// Version 1.01
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 24 March 2008
//
// History:
//
// 1.01 - updated to work with foreign characters in directory/file names (12 April 2008)
// 1.00 - released (24 March 2008)
//
// Output a list of files for jQuery File Tree
//

        $_POST['dir'] = urldecode($_POST['dir']);

        if( file_exists($root . $_POST['dir']) ) {
            $files = scandir($root . $_POST['dir']);
            natcasesort($files);
            if( count($files) > 2 ) { /* The 2 accounts for . and .. */
                echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
                // All dirs
                foreach( $files as $file ) {
                    if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($root . $_POST['dir'] . $file) ) {
                        echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
                    }
                }
                // All files
                foreach( $files as $file ) {
                    if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($root . $_POST['dir'] . $file) ) {
                        $ext = preg_replace('/^.*\./', '', $file);
                        echo "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
                    }
                }
                echo "</ul>";
            }
        }


        // --------------------------------------------

        $block = ob_get_clean();
        return    $block ;
    }
}