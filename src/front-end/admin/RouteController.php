<?php

namespace Vanessa\Admin;
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-21
 * Time: 21:37
 */

use Slim\App as App;
use Slim\Http\Request;
use Slim\Http\Response;

class RouteController
{
	public function __construct(App $app)
	{
		$app->group("/vanessa", function (App $app) {

			$app->get("", function (Request $request, Response $response) {
				return $response->withRedirect("/vanessa/auth");
			});

			$app->map(["GET", "POST"], "/login", function (Request $request, Response $response) {
				return $response->write("Logga in");
			});
			$app->group("/auth", function (App $app) {
				$app->get("/start", function () {

				});
			});
		});
	}
}