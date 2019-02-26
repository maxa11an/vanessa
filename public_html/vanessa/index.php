<?php

if (PHP_SAPI == 'cli-server') {
	$_SERVER['SCRIPT_NAME'] = basename(__FILE__);
	// To help the built-in PHP dev server, check if the request was actually for
	// something which should probably be served as a static file
	$url  = parse_url($_SERVER['REQUEST_URI']);
	$file = __DIR__  . $url['path'];
	if (is_file($file)) {
		return false;
	}
}

include __DIR__.'/../../vendor/autoload.php';

(new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__.'/../../.vanessa/.env');

if(session_status() === PHP_SESSION_NONE){
	session_start();
}

$app = new \Slim\App([
	"settings" => [
		"displayErrorDetails" => true,
		'determineRouteBeforeAppMiddleware' => true
	]
]);


include __DIR__.'/../../src/Vanessa/containers.php';

include __DIR__.'/../../src/Vanessa/middlewares.php';

include __DIR__.'/../../src/Vanessa/routes.php';


$app->run();