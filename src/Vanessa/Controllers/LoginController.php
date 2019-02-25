<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 10:14
 */

namespace Vanessa\Controllers;

use Vanessa\Core\BaseController;
use Vanessa\Core\Localization;
use Vanessa\Core\User;
use Vanessa\Core\VanessaException;

class LoginController extends BaseController
{
	public function login(){
		if($this->request()->isPost()){
			$post = $this->request()->getParsedBody();
			if(isset($post['username']) && isset($post['password'])){
				try{
					User::login($post['username'], $post['password']);
					$this->flash()->addMessage("success", Localization::__("Logged in successfully"));
					return $this->response()->withRedirect($this->router()->pathFor("vanessa:start"));
				}catch(VanessaException $vanessaException){
					$this->flash()->addMessage("danger", $vanessaException->getMessage());
				}
			}
		}
		return $this->view()->render($this->response(), "login.twig");
	}

	public function logout(){
		User::logout();
		return $this->response()->withRedirect($this->router()->pathFor("vanessa:login"));
	}
}