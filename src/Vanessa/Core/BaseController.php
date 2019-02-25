<?php
namespace Vanessa\Core;
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 10:07
 */


/**
 * Class BaseController
 * All admin controllers need to have this as parent.
 * @package Vanessa\Core\Controllers
 * @author Max Allan Niklasson
 */
class BaseController
{
	private $container;
	// constructor receives container instance
	public function __construct(\Psr\Container\ContainerInterface $container) {
		$this->container = $container;
	}

	protected final function container(): \Psr\Container\ContainerInterface {
		return $this->container;
	}

	protected final function view(): \Slim\Views\Twig {
		return $this->container->get('view');
	}

	protected final function flash(): \Slim\Flash\Messages {
		return $this->container->get('flash');
	}

	protected final function router(): \Slim\Router {
		return $this->container->get('router');
	}

	protected final function request(): \Slim\Http\Request {
		return $this->container->get('request');
	}

	protected final function response():  \Slim\Http\Response {
		return $this->container->get('response');
	}

}