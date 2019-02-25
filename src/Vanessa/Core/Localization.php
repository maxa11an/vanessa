<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 12:01
 */

namespace Vanessa\Core;


use Symfony\Component\Yaml\Yaml;

class Localization
{
	const SESSION_NAME = "LOCALIZATION_SESSION";
	const STORAGE_LOCATION = __DIR__."/../../VanessaLocalization/";

	public static function getKey($file, $key){

		if(!@$_SESSION[self::SESSION_NAME][$file]){
			new Localization($file);
		}
		return @$_SESSION[self::SESSION_NAME][$file][$key] ?: $key;
	}



	public function __construct($file)
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		if(!file_exists(self::STORAGE_LOCATION)){
			mkdir(self::STORAGE_LOCATION, 0777, true);
		}
		if(file_exists(self::STORAGE_LOCATION.$file.".yml")){
			$_SESSION[self::SESSION_NAME][$file] = Yaml::parseFile(self::STORAGE_LOCATION.$file.".yml");
		}else{
			$_SESSION[self::SESSION_NAME][$file] = [];
		}

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