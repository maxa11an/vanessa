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
	public static function renderAdd()
	{
		$p = parent::renderAdd();
		$t = [
			"title" => Localization::__("Select field"),
			"sort" => 3
		];

		return array_merge($p, $t);
	}

	public static function renderListItem()
	{
		return [
			'html' => '<div class="center border-left border-right">'.
				'<div class="form-group">'.
				'<label data-ref-name></label>'.
				'<select data-ref-default vanessa-default-options name="fields[][default]"  class="form-control"></select>'.
				'</div>'.
				'</div>',
			'info' => static::renderAdd(),
			'default' => ['type' => static::renderAdd()['name']]
		];
	}

	public static function renderOptions()
	{
		$static = static::renderAdd();
		return [
			'html' =>
				'<div class="form-group">'.
				'<label>{{ __("Options") }} <button type="button" class="btn btn-xs btn-primary" vanessa-options-clone vanessa-options-insert=".options">{{ __("Add option") }}</button></label>'.
				'</div>'.
				'<div class="options inputfield-list inputfield-list-sm p-2" vanessa-options>'.
				'</div>'.
				'<div class="d-none">'.
				'<div class="row item my-2" vanessa-options-cloner>'.
				'<div class="col-5 d-flex align-items-center">'.
				'<div class="form-group">'.
				'<input type="text" class="form-control skip" autocomplete="off" placeholder="{{ __(\'Value\') }}" name="config[options][values][]">'.
				'</div>'.
				'</div>'.
				'<div class="col-5 d-flex align-items-center">'.
				'<div class="form-group">'.
				'<input type="text" class="form-control skip" autocomplete="off" placeholder="{{ __(\'Label\') }}" name="config[options][labels][]">'.
				'</div>'.
				'</div>'.
				'<div class="clickable d-flex col-2 text-danger h3 text-center align-items-center justify-content-center" vanessa-options-remove>&times;</div>'.
				'</div>'.
				'</div>'
			,
			'info' => $static
		];
	}


	public function renderField()
	{

	}

}