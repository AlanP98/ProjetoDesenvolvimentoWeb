<?php

define('DIR', dirname(__FILE__) . '/');

function autoload($classPath) {
	require_once(DIR . $classPath . '.php');
 }

 spl_autoload_register('autoload');