<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-24
 * Time: 22:52
 */

namespace Vanessa;


class StorageFileHandler
{
	const DIR_SECURED = __DIR__.'/../../.vanessa/';

	const SECURED_FILE_SETTINGS = 'settings.yml';
	const SECURED_FILE_USERS = 'users.yml';


	public static function openSecuredStorage(string $filename): YamlSQL{

		if(!file_exists(self::DIR_SECURED.$filename)) file_put_contents(self::DIR_SECURED.$filename, "");

		return new YamlSQL(self::DIR_SECURED.$filename, true);
	}

}