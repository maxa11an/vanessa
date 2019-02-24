<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-24
 * Time: 21:47
 */

include __DIR__.'/../vendor/autoload.php';

(new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__.'/../.vanessa/.env');

$settings = \Vanessa\StorageFileHandler::openSecuredStorage(\Vanessa\StorageFileHandler::SECURED_FILE_USERS);

/*$settings->addNewWithPrimaryKey("administrator", [
	"password" => "lol"
]);*/

$admin = $settings->getFromPrimaryKey("administrator");

var_dump($admin);