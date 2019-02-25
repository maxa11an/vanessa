<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-24
 * Time: 22:52
 */

namespace Vanessa\Core;


class StorageFileHandler
{
	const DIR_SECURED = __DIR__.'/../../../.vanessa/';
	const SECURED_FILE_USERS = 'users.yml';

	const DIR_SITE = __DIR__.'/../../../site/.vanessa/';


	public static function openSecuredStorage(string $filename): YamlSQL{


		return new YamlSQL($filename, true);
	}

	public static function openSiteStorage(string $filename): YamlSQL{

		if(!file_exists(self::DIR_SITE.$filename)) file_put_contents(self::DIR_SITE.$filename, "");

		return new YamlSQL(self::DIR_SITE.$filename, false);
	}

}