<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 11:47
 */

namespace Vanessa\Middlewares;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;


class AuthMiddleware
{
	public function __construct(ContainerInterface $container)
	{

	}
	public function __invoke($request, $response, $next)
	{
		$uri = $request->getUri();
		$path = $uri->getPath();
		if(strpos($path, "/auth") === 0){
			if (!\Vanessa\Core\User::isAuthed()) {
				return $response->withRedirect('/login')->withStatus(301);
			}
		}
		return $next($request, $response);
	}
}