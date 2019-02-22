<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-22
 * Time: 10:36
 */

namespace Vanessa\Twig\Extension;


class __ extends \Twig_Extension
{
	public function getFunctions()
	{
		return [
			new \Twig_Function('__', [$this, 'translate']),
		];
	}

	public function translate(... $args)
	{
		$this->updateFile();
		return new \Vanessa\__($args);
	}

	private function updateFile(){
		foreach (debug_backtrace() as $trace) {
			if (isset($trace['object'])
				&& (strpos($trace['class'], 'TwigTemplate') !== false)
				&& 'Twig_Template' !== get_class($trace['object'])
			) {
				define('__TWIG_FILE__', $trace['object']->getTemplateName());
				break;
			}
		}
	}
}