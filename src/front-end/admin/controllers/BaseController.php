<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-22
 * Time: 08:59
 */

namespace Vanessa\Admin\controllers;


use Psr\Container\ContainerInterface;
use Slim\Views\Twig;

class BaseController
{
	private $container;
	private $view;
	// constructor receives container instance
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
		$this->view = $container->get('view');
	}

	protected final function view(): Twig {
		return $this->view;
	}

	protected final function container(): ContainerInterface {
		return $this->container;
	}

}