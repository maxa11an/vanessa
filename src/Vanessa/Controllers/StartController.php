<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 11:43
 */

namespace Vanessa\Controllers;


use Vanessa\Core\BaseController;

class StartController extends BaseController
{
	public function start(){

		return $this->view()->render($this->response(), 'auth/start.twig');
	}

}