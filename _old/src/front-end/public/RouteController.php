<?php
namespace Vanessa\Publik;
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-21
 * Time: 21:43
 */

class RouteController
{
	public function __construct(\Slim\App $app)
	{
		$app->get("/[{page:!vanessa}]", function(\Slim\Http\Request $request, \Slim\Http\Response $response){
			$page = $request->getAttribute("page");
			if($page == ""){
				$page = "/";
			}
			$pageStorage = \Vanessa\NoSQL::open("pages");
			$pageObject = $pageStorage->where("url", "=", $page)->limit(1)->fetch()[0];

			return $response->write(file_get_contents(__DIR__ . "/../../../.pages/" .$pageObject['filename']));
		});
	}

}