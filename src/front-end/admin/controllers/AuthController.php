<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-22
 * Time: 08:48
 */

namespace Vanessa\Admin\controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Vanessa\User;
use Vanessa\VanessaException;

class AuthController extends BaseController
{

	public function login(Request $request, Response $response, array $args){
		try{
			User::login("test", "test");
		}catch(VanessaException $vanessaException){
			$this->flash()->addMessage("error", $vanessaException->getMessage());
		}

		return $this->view()->render($response, "login.twig");
	}

}