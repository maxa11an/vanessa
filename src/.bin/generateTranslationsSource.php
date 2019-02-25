<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 12:15
 */
include __DIR__.'/../../vendor/autoload.php';
define('STORAGE_LOCATION', __DIR__ . "/../VanessaLocalization/");

$directories = [__DIR__ . '/../Vanessa'];

foreach ($directories as $directory) {
	$it = new \RecursiveDirectoryIterator($directory);
	foreach (new \RecursiveIteratorIterator($it) as $file) {
		if ($file->getExtension() == 'twig' || $file->getExtension() == "php") {
			$keys = array_map(function($v){ return stripslashes($v);}, array_values(array_unique(extractTranslations($file))));
			if (count($keys) > 0) {
				updateTranslationFile($file, $keys);
			}
		}
	}
}

function updateTranslationFile(\SplFileInfo $file, $keys)
{

	if (!file_exists(STORAGE_LOCATION  . "en.yml")) {
		file_put_contents(STORAGE_LOCATION . "en.yml", "");
	}
	$currentKeys = \Symfony\Component\Yaml\Yaml::parseFile(STORAGE_LOCATION .'en.yml');
	foreach ($keys as $translationFile) {
		$currentKeys[$file->getFilename()] = $keys;
	}

	file_put_contents(STORAGE_LOCATION . "en.yml", \Symfony\Component\Yaml\Yaml::dump($currentKeys));
}

function extractTranslations(\SplFileInfo $file)
{
	$regex1 = "/(?:__\((?:(?:\"|'|\s)+)(?:\s)?)([^\"'\\\]*(?:\\\.[^\"'\\\]*)*)(?:(?:\"|'|\s)+\))/m";
	$regex2 = "/(?:__\((?:\"|'|\s)+(?:\s)?)([^\"'\\\]*(?:\\\.[^\"'\\\]*)*)(?:\"|'|\s)+(?:(?:,)\s)+(?:\[)(.*?)(?:\])/m";
	$regex3 = "/(?:__\((?:\"|'|\s)+(?:\s)?)([^\"'\\\]*(?:\\\.[^\"'\\\]*)*)(?:\"|'|\s)+(?:(?:,)\s)+(?:\"|'|\s)+(?:\s)?([^\"'\\\]*(?:\\\.[^\"'\\\]*)*)(?:\"|'|\s)+(?:(?:,)\s)+(?:\[)(.*?)(?:\])/m";
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

	if (count($matches) > 0) {
		if (isset($matches[0]) && count($matches[0]) > 0) {
			$matches[0] = $matches[0][1];
		}
		if (isset($matches[1]) && count($matches[1]) > 0) {
			$matches[1] = $matches[1][1];
		}
		if (isset($matches[2]) && count($matches[2]) > 0) {
			$matches[2] = @array_merge($matches[2][1], $matches[2][2]);
		}
		$matches = call_user_func_array('array_merge', $matches);
		$matches = array_map(function ($match) {
			return trim($match);
		}, $matches);
		return $matches;
	}
	return [];
}