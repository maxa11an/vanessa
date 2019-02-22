<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-22
 * Time: 08:59
 */

namespace Vanessa\Admin\controllers;


use Psr\Container\ContainerInterface;
use Slim\Flash\Messages;
use Slim\Router;
use Slim\Views\Twig;

/**
 * Class BaseController
 * All admin controllers need to have this as parent.
 * @package Vanessa\Admin\controllers
 * @author Max Allan Niklasson
 */
class BaseController
{
	private $container;
	private $view;
	private $flash;
	// constructor receives container instance
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
		$this->view = $container->get('view');
		$this->flash = $container->get('flash');
	}

	protected final function view(): Twig {
		return $this->view;
	}

	protected final function flash(): Messages {
		return $this->flash;
	}

	protected final function container(): ContainerInterface {
		return $this->container;
	}

	protected final function router(): Router {
		return $this->container->router;
	}

}