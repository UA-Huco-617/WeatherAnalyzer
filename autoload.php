<?php

spl_autoload_register('__autoload');

function __autoload($class) {
	$class = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
	echo "Trying to load $class...\n";
	require_once $class;
}

?>