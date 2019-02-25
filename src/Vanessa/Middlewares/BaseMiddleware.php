<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 21:30
 */

namespace Vanessa\Middlewares;


use Psr\Container\ContainerInterface;
use Vanessa\Core\Slim\Arguments;

class BaseMiddleware
{
	private $container;

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	public function __invoke($req, $res, $next)
	{
		$this->container['arguments'] = new Arguments($req->getAttribute('routeInfo')[2]);
		return $next($req, $res);
	}
}