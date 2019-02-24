<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-24
 * Time: 21:47
 */

include __DIR__.'/../vendor/autoload.php';

$_ENV['VANESSA_SECRET'] = "agfkalgfamkldsagfjagfoakglfakl";

$settings = \Vanessa\StorageFileHandler::openSecuredStorage(\Vanessa\StorageFileHandler::SECURED_FILE_SETTINGS);

/*$settings->addNewWithPrimaryKey("administrator", [
	"password" => "lol"
]);*/

$admin = $settings->getFromPrimaryKey("administrator");

var_dump($admin);