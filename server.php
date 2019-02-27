<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-27
 * Time: 00:48
 */
$uri = urldecode(
	parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);
// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.

if(strpos($uri, '/vanessa/') !== FALSE && !file_exists(__DIR__.'/public_html'.$uri)){
	require_once __DIR__.'/public_html/vanessa/index.php';
	return false;
}


if ($uri !== '/' && file_exists(__DIR__.'/public_html'.$uri)) {
	if(file_exists(__DIR__.'/public_html'.$uri.'/index.html')){
		header("Location: ".$uri.'.index.html');
	}
	return false;
}
header("Location: /index.html");


