<?php

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