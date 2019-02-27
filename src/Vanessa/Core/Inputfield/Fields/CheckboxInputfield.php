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
	const NAME = "Checkbox";
	public static function renderAdd()
	{
		$p = parent::renderAdd();
		$t = [
			"title" => Localization::__("Checkbox"),
			"icon" => "https://via.placeholder.com/100?text=Icon",
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
			'<div>'.
			'<input data-ref-default type="checkbox" value="true" name="fields[][default]" placeholder="'.Localization::__("Enter default value").'" autocomplete="off" class="form-check-input">'.
			'<span class="form-check-label">'.Localization::__("Checked as default").'</span>'.
			'</div>'.
			'</div>'.
			'</div>';
		return $p;
	}
}