<?php

namespace Vanessa\Admin\controllers;
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-21
 * Time: 21:37
 */

use Slim\App as App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\TwigExtension;

class RouteController
{
	private $app;
	public function __construct(App $app)
	{
		$this->app = $app;
		$this->__registerRoutes();
		$this->__registerTwig();

	}

	private function __registerRoutes(){
		//Redirect to login when accessing root
		$this->app->any("/vanessa", function(Request $request, Response $response) {
			return $response->withRedirect($this->router->pathFor("vanessa:login"));
		})->setName('vanessa');

		$this->app->map(["GET", "POST"], "/vanessa/login", AuthController::class.':login')->setName('vanessa:login');

	}

	private function __registerTwig(){
		$container = $this->app->getContainer();

		$container['view'] = function ($container) {
			$view = new \Slim\Views\Twig(__DIR__.'/../views', [

			]);
			// Instantiate and add Slim specific extension
			$router = $container->get('router');
			$uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
			$view->addExtension( new TwigExtension($router, $uri));

			return $view;
		};
	}

}