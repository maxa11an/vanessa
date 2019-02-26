<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 21:32
 */

namespace Vanessa\Core\Slim;


class Arguments
{
	private $arguments;
	public function __construct($args)
	{
		$this->arguments = $args;
	}

	public function get($key){
		return @$this->arguments[$key] ?: null;
	}

}