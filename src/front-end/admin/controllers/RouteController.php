<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-21
 * Time: 21:37
 */

namespace Vanessa\Admin\controllers;

use Knlv\Slim\Views\TwigMessages;
use Slim\App as App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\TwigExtension;
use Vanessa\Admin\controllers\auth\StartController;
use Vanessa\Twig\Extension\__;
use Vanessa\Twig\Extension\User;
use Vanessa\VanessaException;

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

		$this->__registerTwig();
		$this->__registerRoutes();


	}

	/**
	 * Register routes
	 */
	private function __registerRoutes()
	{
		$this->app->group('/vanessa', function(App $app){
			//Auth related endpoints
			$app->map(["GET", "POST"], "/login", LoginController::class . ':login')->setName('vanessa:login');
			$app->get("/logout", LoginController::class . ':logout')->setName("vanessa:logout");

			$app->group('/auth', function(App $app){
				$app->get('/start', StartController::class.':start')->setName("vanessa:start");
			});
		});
		/*$this->app->any("/vanessa", function (Request $request, Response $response) {
			return $response->withRedirect($this->router->pathFor("vanessa:login"));
		})->setName('vanessa');*/




	}

	/**
	 * Register twig
	 */
	private function __registerTwig()
	{
		$container = $this->app->getContainer();

		$container['view'] = function ($container) {
			$view = new \Slim\Views\Twig(__DIR__ . '/../views', [

			]);
			// Instantiate and add Slim specific extension
			$router = $container->get('router');
			$uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
			$view->addExtension(new TwigExtension($router, $uri));
			$view->addExtension(new __());
			$view->addExtension(new User());

			$view->addExtension(new TwigMessages(
				new \Slim\Flash\Messages()
			));

			return $view;
		};

		$container['flash'] = function () {
			return new \Slim\Flash\Messages();
		};
	}
}