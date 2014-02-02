<?php

function __autoload($class) {
	$class = str_replace('_', '/', $class) . '.php';
	require_once $class;
}

?>