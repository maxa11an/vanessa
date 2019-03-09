<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 12:01
 */

namespace Vanessa\Core;


use Symfony\Component\Yaml\Yaml;

class Localization extends YamlSession
{
	const SESSION_NAME = "LOCALIZATION_SESSION";
	const STORAGE_LOCATION = __DIR__."/../../VanessaLocalization/";

	public function __construct($file)
	{
		parent::__construct($file, false, self::STORAGE_LOCATION);
	}

	public static function getKey($file, $key){

		$language = "en";

		if($language === "en"){
			return stripslashes($key);
		}

		if(!@$_SESSION[self::SESSION_NAME][$file]){
			$localization = new Localization($file);
			return $localization->getFromFile($key, $file) ?: $key;
		}
		return @$_SESSION[self::SESSION_NAME][$file][$key] ?: $key;
	}

	public function getFromFile($key, $file){
		return parent::get($file)[$key];
	}


	public static function __(... $options){
		$keySingular = null;
		$keyPlural = null;
		$args = null;
		$file = isset($GLOBALS['TWIG_FILE']) ? $GLOBALS['TWIG_FILE'] : basename(debug_backtrace()[0]['file']);
		//if nested somehow
		if(count($options) === 1 && is_array($options[0])){
			$options = $options[0];
		}

		foreach($options as $idx => $option){
			if(is_string($option) && $idx === 0){
				$keySingular = $option;
			}
			if(is_string($option) && $idx === 1){
				$keyPlural = $option;
			}
			if(is_array($option) && $idx > 0){
				$args = $option;
			}
		}

		//check for both plural and singular and make sure there only is one arguments to replace with
		if($keySingular !== null && $keyPlural !== null && count($args) === 1){
			return (string) call_user_func_array('sprintf', array_merge([($args[0] == "1" ? Localization::getKey($file, $keySingular) : Localization::getKey($file, $keyPlural))], $args));
		}
		if(count($args) > 0){
			return (string) call_user_func_array('sprintf', array_merge([Localization::getKey($file, $keySingular)], $args));
		}
		return Localization::getKey($file, $keySingular);
	}
}