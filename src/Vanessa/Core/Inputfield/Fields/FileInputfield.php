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

class FileInputfield extends Inputfield implements InputfieldInterface
{
	public static function renderAdd()
	{
		$p = parent::renderAdd();
		$t = [
			"title" => Localization::__("File upload"),
			"sort" => 7
		];

		return array_merge($p, $t);
	}

	public static function renderListItem()
	{
		return [
			'html' => '<div class="center border-left border-right">'.
				'<div class="form-group">'.
				'<label data-ref-name></label>'.
				'<p data-ref-filetypes></p>'.
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
				'<div class="form-group">' .
				'<label>{{ __("Accepted file types") }}</label>' .
				'<input class="form-control" type="text" value="" placeholder="{{ __("Seperate each filetype with space") }}" name="filetypes">' .
				'</div>'
			,
			'info' => $static
		];
	}



	public function renderField()
	{
		// TODO: Implement renderField() method.
	}

}