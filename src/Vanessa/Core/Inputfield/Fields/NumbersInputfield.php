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

class NumbersInputfield extends Inputfield implements InputfieldInterface
{
	public static function renderAdd()
	{
		$p = parent::renderAdd();
		$t = [
			"title" => Localization::__("Numbers field"),
			"sort" => 3
		];

		return array_merge($p, $t);
	}

	public static function renderOptions()
	{
		$static = static::renderAdd();
		return [
			'html' =>
				'<div class="form-group">' .
				'<label>{{ __("Minimum value") }}</label>' .
				'<input class="form-control" type="number" name="config[min]">' .
				'</div>' .
				'<div class="form-group">' .
				'<label>{{ __("Maximum value") }}</label>' .
				'<input class="form-control" type="number" name="config[max]">' .
				'</div>'
			,
			'info' => $static
		];
	}

	public static function renderListItem()
	{
		return [
			'html' => '<div class="center border-left border-right">' .
				'<div class="form-group">' .
				'<label data-ref-name></label>' .
				'<input data-ref-default type="number"  name="fields[][default]" placeholder="' . Localization::__("Enter default value") . '" autocomplete="off" class="form-control">' .
				'</div>' .
				'</div>',
			'info' => static::renderAdd(),
			'default' => ['type' => static::renderAdd()['name']]
		];
	}


	public function renderField()
	{

	}

}