<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-27
 * Time: 10:08
 */

namespace Vanessa\Core\Twig\Extension;


use Slim\Router;

class VanessaFunctions extends \Twig_Extension
{
	private $router;

	public function getName()
	{
		return 'slim';
	}

	public function __construct(Router $router)
	{
		$this->router = $router;
	}

	public function getFunctions()
	{
		return [
			new \Twig_SimpleFunction('asset', [$this, 'asset'])
		];
	}

	public function asset($file){
		return $this->router->getBasePath().'/assets/'.$file;
	}
}