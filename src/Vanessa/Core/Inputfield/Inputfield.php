<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 17:47
 */

namespace Vanessa\Core\Inputfield;


use Vanessa\Core\Localization;

class Inputfield implements InputfieldInterface
{
	protected $name;
	protected $placeholder;
	protected $options;
	const DEFAULT_OPTIONS = [
		"required" => false
	];
	public function __construct(string $name, string $placeholder, array $options)
	{
		$this->name = $name;
		$this->placeholder = $placeholder;
		$this->options = array_merge(self::DEFAULT_OPTIONS, $options);
	}

	public static function renderAdd()
	{
		return [
			"Inputfield" => array_values(array_slice(explode("\\", get_called_class()), -1))[0]
		];
	}

	public static function renderListItem()
	{
		return [
			'html' => '<div class="center border-left border-right">'.
				'<div class="form-group">'.
				'<label></label>'.
				'<input type="text" name="fields[][default]" placeholder="'.Localization::__("Enter default value").'" autocomplete="off" class="form-control">'.
				'</div>'.
				'</div>',
			'info' => static::renderAdd()
		];
	}

	public static function renderOptions()
	{
		$static = static::renderAdd();
		return [
			'html' =>
				'<form>'.
					'<div class="form-group"><label>{{ __("Label") }}</label><p>{{ __("The label is show in editor of the field") }}</p><input class="form-control" type="text" name="label" placeholder="{{ __("Label goes here") }}"></div>'.
					'<div class="form-group"><label>{{ __("Name") }}</label><p class="text-light font-italic text-muted">{{ __("The name of the field") }}</p><input class="form-control" type="text" name="label" placeholder="{{ __("Name goes here") }}"></div>'.
				'</form>',
			'info' => $static
		];
	}

	public function renderField()
	{
		// TODO: Implement renderField() method.
	}
}