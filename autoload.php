<?php

//	Register this autoload function so that things like PHPUnit can see it.
spl_autoload_register('__autoload');

function __autoload($class) {
	$class = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
	require_once $class;
}

?>