<?php

// @see https://github.com/filegator/filegator

// @see https://codeshack.io/file-management-system-php/
// Convert bytes to human readable format
function convert_filesize($bytes, $precision = 2) {
    $units = ['Bytes', 'KB', 'MB', 'GB', 'TB']; 
    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow]; 
}

// @see https://gitee.com/null_952_0170/simple-file-manager/blob/master/index.php

function recursiveDel($dir) {
    if ($dir[strlen($dir) - 1] != "/")
        $dir = $dir."/";
    $mydir = opendir($dir);
    while(($file = readdir($mydir)) !== false) {
        if($file != "." && $file != "..") {
            // Unix compat
            chmod($dir.$file, 0777);
            if(is_dir($dir.$file)) {
                chdir('.');
                recursiveDel($dir.$file.'/');
                rmdir($dir.$file);
            }
            else
                unlink($dir.$file);
        }
    }
    closedir($mydir);
    rmdir($dir);
}

// from: http://php.net/manual/en/function.realpath.php#84012
function get_absolute_path($path) {
    $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    $parts = explode(DIRECTORY_SEPARATOR, $path);
    $absolutes = [];
    foreach ($parts as $part) {
        if ('.' == $part) continue;
        if ('..' == $part) {
            array_pop($absolutes);
        } else {
            $absolutes[] = $part;
        }
    }
    return implode(DIRECTORY_SEPARATOR, $absolutes);
}

function is_recursively_deleteable($d) {
	$stack = [$d];
	while($dir = array_pop($stack)) {
		if(!is_readable($dir) || !is_writable($dir))
			return false;
		$files = array_diff(scandir($dir), ['.','..']);
		foreach($files as $file) if(is_dir($file)) {
			$stack[] = "$dir/$file";
		}
	}
	return true;
}

function rmrf($dir) {
	if(is_dir($dir)) {
		$files = array_diff(scandir($dir), ['.','..']);
		foreach ($files as $file)
			rmrf("$dir/$file");
		rmdir($dir);
	} else {
		unlink($dir);
	}
}