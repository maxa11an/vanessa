<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-21
 * Time: 20:53
 */

namespace Vanessa;


use SleekDB\SleekDB;

class NoSQL
{
	public static function open(string $table): SleekDB
	{
		return SleekDB::store($table, "./.storage/", [
			'auto_cache' => true,
			'timeout' => 120
		]);
	}

}