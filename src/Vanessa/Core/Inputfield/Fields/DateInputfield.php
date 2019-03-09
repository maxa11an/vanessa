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

class DateInputfield extends Inputfield implements InputfieldInterface
{
	public static function defaultOptions():array{
		return [
			"blank" => "",
			"today" => Localization::__("Today\'s date")
		];
	}

	public static function renderAdd()
	{
		$p = parent::renderAdd();
		$t = [
			"title" => Localization::__("Date field"),
			"sort" => 6
		];

		return array_merge($p, $t);
	}

	public static function renderListItem()
	{
		return [
			'html' => '<div class="center border-left border-right">'.
				'<div class="form-group">'.
				'<label data-ref-name></label>'.
				'<select data-ref-default name="fields[][default]"  class="form-control">'.
				join("", array_map(function($l, $v){
					return "<option value='$v'>$l</option>";
					}, self::defaultOptions(), array_keys(self::defaultOptions()))).
				'</select>'.
				'</div>'.
				'</div>',
			'info' => static::renderAdd(),
			'default' => ['type' => static::renderAdd()['name']]
		];
	}

	public function renderField()
	{

	}

}