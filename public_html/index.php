<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-21
 * Time: 21:28
 */

require_once __DIR__."/../vendor/autoload.php";


$configuration = [
	'settings' => [
		'displayErrorDetails' => true,
	],
];

$c = new \Slim\Container($configuration);


$app = new \Slim\App($c);

new \Vanessa\Admin\RouteController($app);

new \Vanessa\Publik\RouteController($app);

new \Vanessa\Admin\AuthMiddleware($app);

$app->add(function(\Slim\Http\Request $request, \Slim\Http\Response $response, callable $next){
	$uri = $request->getUri();
	$path = $uri->getPath();
	if ($path != '/' && substr($path, -1) == '/') {
		// permanently redirect paths with a trailing slash
		// to their non-trailing counterpart
		$uri = $uri->withPath(substr($path, 0, -1));

		if ($request->getMethod() == 'GET') {
			return $response->withRedirect((string)$uri, 301);
		} else {
			return $next($request->withUri($uri), $response);
		}
	}
	return $next($request, $response);
});


$app->run();