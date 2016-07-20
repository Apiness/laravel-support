<?php

if (!function_exists('activeRoute')) {
	function activeRoute($name, $class = 'active')
	{
		return (Route::is($name) ? $class : '');
	}
}

if (!function_exists('activeURL')) {
	function activeURL($URL, $class = 'active')
	{
		return (Request::is($URL) ? $class : '');
	}
}
