<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-24
 * Time: 22:48
 */

namespace Vanessa\Core;


class Settings extends YamlSession
{
	const SESSION_NAME = "SETTINGS_SESSION";
	const STORAGE_FILE = 'settings.yml';

	public function __construct()
	{
		$this->sessionName = self::SESSION_NAME;
		$this->storageFile = self::STORAGE_FILE;
		parent::__construct();
	}
}