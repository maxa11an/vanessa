<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-22
 * Time: 12:23
 */

namespace Vanessa;


class Localization
{
	const SESSION_NAME = "LOCALIZATION_SESSION";
	const STORAGE_LOCATION = "./.localization/";

	public static function getKey($file, $key){
		$hashedFile = md5($file);
		if(!$_SESSION[self::SESSION_NAME][$hashedFile]){
			new Localization($hashedFile);
		}
		return @$_SESSION[self::SESSION_NAME][$hashedFile][$key] ?: $key;
	}



	public function __construct($file)
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		if(!file_exists(self::STORAGE_LOCATION)){
			mkdir(self::STORAGE_LOCATION, 0777, true);
		}
		if(file_exists(self::STORAGE_LOCATION.$file.".json")){
			$_SESSION[self::SESSION_NAME][$file] = json_decode(file_get_contents(self::STORAGE_LOCATION.$file.".json"), true);
		}else{
			$_SESSION[self::SESSION_NAME][$file] = [];
		}

	}

	public static function generateTranslationsFiles(){

		$it = new \RecursiveDirectoryIterator("./src/front-end/admin");
		foreach(new \RecursiveIteratorIterator($it) as $file) {
			if ($file->getExtension() == 'twig' || $file->getExtension() == "php") {
				$keys = self::extractTranslations($file);
				if(count($keys) > 0){
					self::updateTranslationFile($file, $keys);
				}
			}
		}
		$it = new \RecursiveDirectoryIterator("./src/core");
		foreach(new \RecursiveIteratorIterator($it) as $file) {
			if ($file->getExtension() == 'twig' || $file->getExtension() == "php") {
				$keys = self::extractTranslations($file);
				if(count($keys) > 0){
					self::updateTranslationFile($file, $keys);
				}

			}
		}
	}

	private static function updateTranslationFile(\SplFileInfo $file, $keys){
		if(!file_exists(self::STORAGE_LOCATION.md5($file->getFileName()).".json")){
			file_put_contents(self::STORAGE_LOCATION.md5($file->getFileName()).".json", json_encode([]));
		}
		$existingKeys = \json_decode(file_get_contents(self::STORAGE_LOCATION.md5($file->getFileName()).".json"),true);
		foreach($keys as $key){
			if(!isset($existingKeys[$key])){
				$existingKeys[$key] = [];
			}
		}

		file_put_contents(self::STORAGE_LOCATION.md5($file->getFileName()).".json", \json_encode($existingKeys, JSON_PRETTY_PRINT));
	}

	private static function extractTranslations(\SplFileInfo $file){
		$regex1 = '/(?:__\((?:(?:"|\'|\s)+)(?:\s)?)([^\'"]*)(?:(?:"|\'|\s)+\))/m';
		$regex2 = '/(?:__\((?:"|\'|\s)+(?:\s)?)([^\'"]*)(?:"|\'|\s)+(?:(?:,)\s)+(?:\[)(.*?)(?:\])/m';
		$regex3 = '/(?:__\((?:"|\'|\s)+(?:\s)?)([^\'"]*)(?:"|\'|\s)+(?:(?:,)\s)+(?:"|\'|\s)+(?:\s)?([^\'"]*)(?:"|\'|\s)+(?:(?:,)\s)+(?:\[)(.*?)(?:\])/m';
		$matches = [
			0 => [],
			1 => [],
			2 => []
		];
		$content = file_get_contents($file);

		preg_match_all($regex1, $content, $matches[0]);
		preg_match_all($regex2, $content, $matches[1]);
		preg_match_all($regex3, $content, $matches[2]);

		$matches = array_filter(array_map('array_filter', $matches));

		if(count($matches) > 0){
			if(isset($matches[0]) && count($matches[0]) > 0){
				$matches[0] = $matches[0][1];
			}
			if(isset($matches[1]) && count($matches[1]) > 0){
				$matches[1] = $matches[1][1];
			}
			if(isset($matches[2]) && count($matches[2]) > 0){
				$matches[2] = @array_merge($matches[2][1], $matches[2][2]);
			}
			$matches = call_user_func_array('array_merge', $matches);
			$matches = array_map(function($match){
				return trim($match);
			}, $matches);
			return $matches;
		}
		return [];

	}
}