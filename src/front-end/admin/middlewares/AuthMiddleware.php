<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-21
 * Time: 22:35
 */

namespace Vanessa\Admin\middlewares;


use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Vanessa\User;

class AuthMiddleware
{
	public function __construct(App $app)
	{
		$app->add(function(Request $request, Response $response, callable $next){
			$uri = $request->getUri();
			$path = $uri->getPath();
			if(strpos($path, "/vanessa/auth") === 0){
				if (!User::isAuth()) {
					return $response->withRedirect('/vanessa/login')->withStatus(301);
				}
			}
			return $next($request, $response);
		});
	}

}