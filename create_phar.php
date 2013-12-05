<?php

if (count($argv) < 2) {
	echo "Usage example: php create_phar.php [phar_file] [source_directory]\n";
	exit();
}

$pharer = new Pharer();
if (!$pharer->canCreatePhar()) {
	echo "Phar creating is disabled in you php.ini config. Set phar.readonly to Off to start creating phar files.\n";
	exit();
}

$phar_file = getcwd().'/'.$argv[1];
$src = getcwd().'/'.$argv[2];

$pharer->createPhar($phar_file, $src);


class Pharer
{
	public function canCreatePhar()
	{
		return !ini_get('phar.readonly');
	}

	public function createPhar($phar_file, $src)
	{
		$dir = $this->readSrcDir($src);
		if (empty($dir)) {
			echo "Directory empty";
			return;
		}
		$phar = new Phar($phar_file, FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, basename($phar_file));

		foreach ($dir as $v) {
			$phar[$v] = file_get_contents($src."/$v");
		}
		if (isset($dir['index.php'])) {
			$phar->setStub($phar->createDefaultStub("index.php"));
		}
	}

	public function readSrcDir($src, $basedir = '')
	{
		$dir = [];
		$list = scandir($src.'/'.$basedir);
		foreach ($list as $v) {
			if (!trim($v, '.')) {
				continue;
			}

			$path = $src.'/'.$basedir.$v;
			if (is_dir($path)) {
				$dir = array_merge($dir, $this->readSrcDir($src, $basedir.$v.'/'));
			} else {
				$dir[] = $basedir.$v;
			}
		}
		return $dir;
	}
}