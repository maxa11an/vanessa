<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 14:03
 */

namespace Vanessa\Core\Twig\Extension;


class Vanessa extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
	public function getGlobals()
	{
		new \Vanessa\Core\Settings();
		return [
			"vanessa" => [
				"settings" => \Vanessa\Core\Settings::toArray(\Vanessa\Core\Settings::SESSION_NAME),
				"user" => \Vanessa\Core\User::getLoggedInUser()
			]
		];
	}

}