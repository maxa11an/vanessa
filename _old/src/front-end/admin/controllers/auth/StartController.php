<?php
/**
 * Date: 2019-02-22
 * Time: 10:02
 */

namespace Vanessa\Admin\controllers\auth;

use Slim\Http\Request;
use Slim\Http\Response;

class StartController extends \Vanessa\Admin\controllers\BaseController
{

	public function start(Request $request, Response $response, array $args)
	{
		return $this->view()->render($response, "auth/start.twig");
	}

}