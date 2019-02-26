<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 21:51
 */

namespace Vanessa\Core\Inputfield;


class InputFieldLoad
{
	/**
	 * @return array[\Vanessa\Core\InputField]
	 */
	public static function all():array {
		$it = new \RecursiveDirectoryIterator(__DIR__.'/Fields');
		$fields = [];
		foreach (new \RecursiveIteratorIterator($it) as $file) {
			if($file instanceof \SplFileInfo){
				if($file->isFile()){
					$field = "\\Vanessa\\Core\\Inputfield\\Fields\\".str_replace(".php", "", $file->getFilename());
					$fields[] = $field;
				}
			}
		}

		return $fields;
	}

}