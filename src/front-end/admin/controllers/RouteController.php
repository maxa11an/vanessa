<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-21
 * Time: 21:37
 */
namespace Vanessa\Admin\controllers;
use Slim\App as App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\TwigExtension;
use Vanessa\Twig\Extension\__;

/**
 * Class RouteController
 * Register routes for admin panel and includes Twig since we use this as template engine.
 *
 * @package Vanessa\Admin\controllers
 * @author Max Allan Niklasson
 */
class RouteController
{
	private $app;

	/**
	 * RouteController constructor.
	 * @param App $app
	 */
	public function __construct(App $app)
	{
		$this->app = $app;
		$this->__registerRoutes();
		$this->__registerTwig();

	}

	/**
	 * Register routes
	 */
	private function __registerRoutes(){
		//Redirect to login when accessing root
		$this->app->any("/vanessa", function(Request $request, Response $response) {
			return $response->withRedirect($this->router->pathFor("vanessa:login"));
		})->setName('vanessa');

		$this->app->map(["GET", "POST"], "/vanessa/login", AuthController::class.':login')->setName('vanessa:login');

	}

	/**
	 * Register twig
	 */
	private function __registerTwig(){
		$container = $this->app->getContainer();

		$container['view'] = function ($container) {
			$view = new \Slim\Views\Twig(__DIR__.'/../views', [

			]);
			// Instantiate and add Slim specific extension
			$router = $container->get('router');
			$uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
			$view->addExtension( new TwigExtension($router, $uri));
			$view->addExtension( new __());

			return $view;
		};
	}

}