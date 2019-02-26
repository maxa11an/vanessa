<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 22:06
 */

namespace Vanessa\Core\Inputfield\Fields;

use Vanessa\Core\Inputfield\Inputfield;
use Vanessa\Core\Inputfield\InputfieldInterface;
use Vanessa\Core\Localization;

class ColorpickerInputfield extends Inputfield implements InputfieldInterface
{
	const NAME = "Checkbox";
	public static function renderAdd()
	{
		$p = parent::renderAdd();
		$t = [
			"title" => Localization::__("Colorpicker"),
			"icon" => "https://via.placeholder.com/100?text=Icon",
			"sort" => 9
		];
		return array_merge($p, $t);
	}



	public function renderField()
	{
		// TODO: Implement renderField() method.
	}


}