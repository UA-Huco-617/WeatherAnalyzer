<?php

function __autoload($class) {
	$class = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
	require_once $class;
}

?>