<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-22
 * Time: 10:36
 */

namespace Vanessa\Twig\Extension;


use Twig\TwigFunction;

class __ extends \Twig_Extension
{
	public function getFunctions()
	{
		return [
			new TwigFunction('__', [$this, 'translate']),
		];
	}

	public function translate(... $args)
	{
		return new \Vanessa\__($args);
	}
}