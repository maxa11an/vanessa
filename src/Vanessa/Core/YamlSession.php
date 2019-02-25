<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 14:05
 */

namespace Vanessa\Core;


use Symfony\Component\Yaml\Yaml;

class YamlSession extends YamlSQL
{
	protected $sessionName = null;

	public function __construct($file = null, $encrypted = false, $optionalPath = null)
	{
		if($file !== null){
			parent::__construct($file, $encrypted, $optionalPath);
			$_SESSION[$this->sessionName][$file] = $this->getAll();
		}else{
			parent::__construct($this->storageFile, $encrypted, $optionalPath);
			$_SESSION[$this->sessionName] = $this->getAll();
		}


	}

	public function get($key){
		return $_SESSION[$this->sessionName][$key] ?: null;
	}


}