<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 21:47
 */

namespace Vanessa\Core\Inputfield;


interface InputfieldInterface
{

	public function renderField();
	public static function renderOptions();
	public static function renderAdd();
	public static function renderListItem();
	public static function validateInput($input, array $field = []);

}