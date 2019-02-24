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

class LoginController extends BaseController
{

	public function login(Request $request, Response $response, array $args){

		if($request->isPost()){
			$post = $request->getParsedBody();
			try{
				User::login($post['username'], $post['password']);
				$this->flash()->addMessage("success", "Loggade in");
				return $response->withRedirect($this->router()->pathFor("vanessa:start"));
			}catch (VanessaException $vanessaException){
				$this->flash()->addMessage("error", $vanessaException->getMessage());
			}
		}

		return $this->view()->render($response, "login.twig");
	}

	public function logout(Request $request, Response $response){
		User::logout();
		return $response->withRedirect($this->router()->pathFor('vanessa:login'));
	}

}