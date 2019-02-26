<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 21:44
 */

namespace Vanessa\Core\Inputfield\Fields;


use Vanessa\Core\Inputfield\Inputfield;
use Vanessa\Core\Inputfield\InputfieldInterface;
use Vanessa\Core\Localization;

class SelectInputfield extends Inputfield implements InputfieldInterface
{
	const NAME = "Text";
	public static function renderAdd()
	{
		$p = parent::renderAdd();
		$t = [
			"title" => Localization::__("Select Field"),
			"icon" => "https://via.placeholder.com/100?text=Icon",
			"sort" => 3
		];

		return array_merge($p, $t);
	}



	public function renderField()
	{

	}

	public function renderOptions()
	{
		// TODO: Implement renderOptions() method.
	}
}