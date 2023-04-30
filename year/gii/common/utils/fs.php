<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/6/20
 * Time: 19:37
 */

namespace year\gii\common\utils;

use \Exception ;
// ini_set('open_basedir', dirname(__FILE__) . DIRECTORY_SEPARATOR);

/**
 * COPY FROM  jstree demo
 * Class fs
 *
 * @see https://github.com/vakata/jstree-php-demos
 * @package year\gii\migration\utils
 */
class fs
{
    protected $base = null;

    protected function real($path) {
        $temp = realpath($path);
        if(!$temp) { throw new Exception('Path does not exist: ' . $path); }
        if($this->base && strlen($this->base)) {
            if(strpos($temp, $this->base) !== 0) { throw new Exception('Path is not inside base ('.$this->base.'): ' . $temp); }
        }
        return $temp;
    }
    public function path($id) {
        $id = str_replace('/', DIRECTORY_SEPARATOR, $id);
        $id = trim($id, DIRECTORY_SEPARATOR);
        $id = $this->real($this->base . DIRECTORY_SEPARATOR . $id);
        return $id;
    }
    protected function id($path) {
        $path = $this->real($path);
        $path = substr($path, strlen($this->base));
        $path = str_replace(DIRECTORY_SEPARATOR, '/', $path);
        $path = trim($path, '/');
        return strlen($path) ? $path : '/';
    }

    public function __construct($base) {
        $this->base = $this->real($base);
        if(!$this->base) { throw new Exception('Base directory does not exist'); }
    }
    public function lst($id, $with_root = false) {
        // print_r($id);
        // die(__FILE__) ; 
        $dir = $this->path($id);
        $lst = @scandir($dir);
        if(!$lst) { throw new Exception('Could not list path: ' . $dir); }
        $res = array();
        foreach($lst as $item) {
            if($item == '.' || $item == '..' || $item === null) { continue; }
            if($this->startsWith($item,'.')) { continue; }

            $tmp = preg_match('([^ a-zа-я-_0-9.]+)ui', $item);
            if($tmp === false || $tmp === 1) { continue; }
            if(is_dir($dir . DIRECTORY_SEPARATOR . $item)) {
                $res[] = array('text' => $item, 'children' => true,  'id' => $this->id($dir . DIRECTORY_SEPARATOR . $item), 'icon' => 'folder');
            }
            else {
                $res[] = array('text' => $item, 'children' => false, 'id' => $this->id($dir . DIRECTORY_SEPARATOR . $item), 'type' => 'file', 'icon' => 'file file-'.substr($item, strrpos($item,'.') + 1));
            }
        }
        if($with_root && $this->id($dir) === '/') {
            $res = array(array('text' => basename($this->base), 'children' => $res, 'id' => '/', 'icon'=>'folder', 'state' => array('opened' => true, 'disabled' => true)));
        }
        return $res;
    }
    public function data($id) {
        if(strpos($id, ":")) {
            $id = array_map(array($this, 'id'), explode(':', $id));
            return array('type'=>'multiple', 'content'=> 'Multiple selected: ' . implode(' ', $id));
        }
        $dir = $this->path($id);
        if(is_dir($dir)) {
            return array('type'=>'folder', 'content'=> $id);
        }
        if(is_file($dir)) {
            $ext = strpos($dir, '.') !== FALSE ? substr($dir, strrpos($dir, '.') + 1) : '';
            $dat = array('type' => $ext, 'content' => '');
            switch($ext) {
                case 'txt':
                case 'text':
                case 'md':
                case 'js':
                case 'json':
                case 'css':
                case 'html':
                case 'htm':
                case 'xml':
                case 'c':
                case 'cpp':
                case 'h':
                case 'sql':
                case 'log':
                case 'py':
                case 'rb':
                case 'htaccess':
                case 'php':
                    $dat['content'] = file_get_contents($dir);
                    break;
                case 'jpg':
                case 'jpeg':
                case 'gif':
                case 'png':
                case 'bmp':
                    $dat['content'] = 'data:'.finfo_file(finfo_open(FILEINFO_MIME_TYPE), $dir).';base64,'.base64_encode(file_get_contents($dir));
                    break;
                default:
                    $dat['content'] = 'File not recognized: '.$this->id($dir);
                    break;
            }
            return $dat;
        }
        throw new \Exception('Not a valid selection: ' . $dir);
    }
    public function create($id, $name, $mkdir = false) {
        $dir = $this->path($id);
        if(preg_match('([^ a-zа-я-_0-9.]+)ui', $name) || !strlen($name)) {
            throw new Exception('Invalid name: ' . $name);
        }
        if($mkdir) {
            mkdir($dir . DIRECTORY_SEPARATOR . $name);
        }
        else {
            file_put_contents($dir . DIRECTORY_SEPARATOR . $name, '');
        }
        return array('id' => $this->id($dir . DIRECTORY_SEPARATOR . $name));
    }
    public function rename($id, $name) {
        $dir = $this->path($id);
        if($dir === $this->base) {
            throw new Exception('Cannot rename root');
        }
        if(preg_match('([^ a-zа-я-_0-9.]+)ui', $name) || !strlen($name)) {
            throw new Exception('Invalid name: ' . $name);
        }
        $new = explode(DIRECTORY_SEPARATOR, $dir);
        array_pop($new);
        array_push($new, $name);
        $new = implode(DIRECTORY_SEPARATOR, $new);
        if($dir !== $new) {
            if(is_file($new) || is_dir($new)) { throw new Exception('Path already exists: ' . $new); }
            rename($dir, $new);
        }
        return array('id' => $this->id($new));
    }
    public function remove($id) {
        $dir = $this->path($id);
        if($dir === $this->base) {
            throw new Exception('Cannot remove root');
        }
        if(is_dir($dir)) {
            foreach(array_diff(scandir($dir), array(".", "..")) as $f) {
                $this->remove($this->id($dir . DIRECTORY_SEPARATOR . $f));
            }
            rmdir($dir);
        }
        if(is_file($dir)) {
            unlink($dir);
        }
        return array('status' => 'OK');
    }
    public function move($id, $par) {
        $dir = $this->path($id);
        $par = $this->path($par);
        $new = explode(DIRECTORY_SEPARATOR, $dir);
        $new = array_pop($new);
        $new = $par . DIRECTORY_SEPARATOR . $new;
        rename($dir, $new);
        return array('id' => $this->id($new));
    }
    public function copy($id, $par) {
        $dir = $this->path($id);
        $par = $this->path($par);
        $new = explode(DIRECTORY_SEPARATOR, $dir);
        $new = array_pop($new);
        $new = $par . DIRECTORY_SEPARATOR . $new;
        if(is_file($new) || is_dir($new)) { throw new Exception('Path already exists: ' . $new); }

        if(is_dir($dir)) {
            mkdir($new);
            foreach(array_diff(scandir($dir), array(".", "..")) as $f) {
                $this->copy($this->id($dir . DIRECTORY_SEPARATOR . $f), $this->id($new));
            }
        }
        if(is_file($dir)) {
            copy($dir, $new);
        }
        return array('id' => $this->id($new));
    }

    protected function startsWith($haystack, $needle)
    {
        $length = strlen($needle); 
        return (substr($haystack, 0, $length) === $needle);
     }

     function endsWith($haystack, $needle)
     {
        $length = strlen($needle); 
        if ($length == 0) { 
            return true;
         }
          return (substr($haystack, -$length) === $needle); }
}

// @see https://www.php.net/manual/zh/function.str-starts-with.php
// source: Laravel Framework
// https://github.com/laravel/framework/blob/8.x/src/Illuminate/Support/Str.php
if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle) {
        return (string)$needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}
if (!function_exists('str_ends_with')) {
    function str_ends_with($haystack, $needle) {
        return $needle !== '' && substr($haystack, -strlen($needle)) === (string)$needle;
    }
}
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}