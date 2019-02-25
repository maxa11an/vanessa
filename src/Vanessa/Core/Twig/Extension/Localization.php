<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 11:59
 */

namespace Vanessa\Core\Twig\Extension;


class Localization extends \Twig_Extension
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
		return \Vanessa\Core\Localization::__($args);
	}

	private function updateFile()
	{
		foreach (debug_backtrace() as $trace) {
			if (isset($trace['object'])
				&& (strpos($trace['class'], 'TwigTemplate') !== false)
				&& 'Twig_Template' !== get_class($trace['object'])
			) {
				$GLOBALS['TWIG_FILE'] = $trace['object']->getTemplateName();
				break;
			}
		}
	}
}