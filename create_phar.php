<?php
if (count($argv) < 2) {

} else {
	$phar_file = getcwd().'/'.$argv[1];
	$src = getcwd().'/'.$argv[2];
	createPhar($phar_file, $src); die;
}

function createPhar($phar_file, $src)
{
	$dir = readSrcDir($src);
	if (empty($dir)) {
		echo "Directory empty";
		exit;
	}
	$phar = new Phar($phar_file, FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, basename($phar_file));
	
	foreach ($dir as $v) {
		$phar[$v] = file_get_contents($src."/$v");
	}
	if (isset($dir['index.php'])) {
		$phar->setStub($phar->createDefaultStub("index.php"));
	}
}

function readSrcDir($src, $basedir = '')
{
	$dir = [];
	$list = scandir($src.'/'.$basedir);
	foreach ($list as $v) {
		if (!trim($v, '.')) continue;
		$path = $src.'/'.$basedir.$v;
		if (is_dir($path)) {
			$dir = array_merge($dir, readSrcDir($src, $basedir.$v.'/'));
		} else {
			$dir[] = $basedir.$v;
		}
	}
	return $dir;
}