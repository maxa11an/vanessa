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
			"Inputfield" => array_values(array_slice(explode("\\", get_called_class()), -1))[0],
			"name" => strtolower(str_replace("Inputfield", "", array_values(array_slice(explode("\\", get_called_class()), -1))[0]))
		];
	}

	public static function renderListItem()
	{
		return [
			'html' => '<div class="center border-left border-right">'.
				'<div class="form-group">'.
				'<label data-ref-name></label>'.
				'<input data-ref-default type="text" name="fields[][default]" placeholder="'.Localization::__("Enter default value").'" autocomplete="off" class="form-control">'.
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
				'',
			'info' => $static
		];
	}

	public static function validateInput($input, array $field = [])
	{
		return $input;
	}

	public function renderField()
	{
		// TODO: Implement renderField() method.
	}
}