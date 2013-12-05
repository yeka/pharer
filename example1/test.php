<?php

require_once('phar://example1.phar/Foo/Bar.php');

use Foo\Bar;
$test = new Bar();
$test->say();