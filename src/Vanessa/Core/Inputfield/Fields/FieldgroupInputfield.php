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

class FieldgroupInputfield extends Inputfield implements InputfieldInterface
{
	public static function renderAdd()
	{
		$p = parent::renderAdd();
		$t = [
			"title" => Localization::__("Field group"),
			"sort" => 11
		];

		return array_merge($p, $t);
	}

	public static function renderListItem()
	{
		/**
		 * <div class="d-flex flex-column h-75 align-self-center">
		<div class="mb-auto clickable item-action-up">
		<span class="lnr lnr-chevron-up"></span>
		</div>
		<div class="mt-auto clickable item-action-down">
		<span class="lnr lnr-chevron-down"></span>
		</div>
		</div>
		<div class="flex-grow-1 px-3 d-flex align-items-center ">
		{{ field.html|raw }}
		</div>
		<div class="d-flex flex-column h-75 align-self-center">
		<div class="mb-auto clickable item-action-settings">
		<span class="lnr lnr-cog"></span>
		</div>
		<div class="mt-auto clickable item-action-remove">
		<span class="lnr lnr-trash"></span>
		</div>
		</div>
		 */
		return [
			'outerHtml' => '<div data-vanessa-fill-left-editor="" class="clickable bg-white border-primary border-left border-right border-top border-bottom rounded flex-grow-1 mx-5 h-75 align-self-center px-3 d-flex align-items-center">' .
				'<label class="m-0" data-ref-name></label>' .
				'<img src="{{ asset("icons/ArrowRight.svg") }}" class="ml-auto h-100 img-fluid">'.
				'</div>'.
				'<textarea class="d-none" name="fields[][yaml]"></textarea>',
			'info' => static::renderAdd(),
			'default' => ['type' => static::renderAdd()['name']]
		];
	}


	public function renderField()
	{
		// TODO: Implement renderField() method.
	}

}