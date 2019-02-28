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

class CheckboxInputfield extends Inputfield implements InputfieldInterface
{
	public static function renderAdd()
	{
		$p = parent::renderAdd();
		$t = [
			"title" => Localization::__("Checkbox"),
			"sort" => 4
		];

		return array_merge($p, $t);
	}



	public function renderField()
	{
		// TODO: Implement renderField() method.
	}

	public static function renderListItem(){
		$p = parent::renderListItem();
		$p['html'] = '<div class="center border-left border-right">'.
			'<div class="form-group">'.
			'<label data-ref-name></label>'.
			'<div class="switch-group success round">'.
			'<label>'.
			'<input data-ref-default type="checkbox" name="fields[][default]" />'.
			'<span></span>'.Localization::__("Default state of checkbox").
			'</label>'.
			'</div>'.
			'</div>'.
			'</div>';
		return $p;
	}
}