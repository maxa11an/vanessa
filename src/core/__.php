<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-21
 * Time: 21:07
 */

namespace Vanessa;

/**
 * Class __
 * @package Vanessa
 */
class __
{
	private $keySingular = null;
	private $keyPlural = null;
	private $args = [];

	/**
	 * __ constructor.
	 * @param mixed ...$options Supports three different ways of printing data: __("Normal") => "Normal", __("Normal %s", ["String"] ) => "Normal String", __("Singular %d", "Plural %d", [2]) => "Plural 2"
	 */
	public function __construct(... $options)
	{
		//if nested somehow
		if(count($options) === 1 && is_array($options[0])){
			$options = $options[0];
		}

		foreach($options as $idx => $option){
			if(is_string($option) && $idx === 0){
				$this->keySingular = $option;
			}
			if(is_string($option) && $idx === 1){
				$this->keyPlural = $option;
			}
			if(is_array($option) && $idx > 0){
				$this->args = $option;
			}
		}
	}

	public function __toString()
	{
		//check for both plural and singular and make sure there only is one arguments to replace with
		if($this->keySingular !== null && $this->keyPlural !== null && count($this->args) === 1){
			return (string) call_user_func_array('sprintf', array_merge([($this->args[0] == "1" ? $this->keySingular : $this->keyPlural)], $this->args));
		}
		if(count($this->args) > 0){
			return (string) call_user_func_array('sprintf', array_merge([$this->keySingular], $this->args));
		}
		return $this->keySingular;
	}

}