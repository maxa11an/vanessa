<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-22
 * Time: 23:58
 */

namespace Vanessa\Twig\Extension;


class User extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
	public function getGlobals()
	{
		return [
			"user" => [
				"credentials" => \Vanessa\User::getLoggedInUser(),
				"isLoggedIn" => \Vanessa\User::isAuthed()
			]
		];
	}

}