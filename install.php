<?php

include "vendor/autoload.php";

define("VANESSA_STORAGE", '.vanessa');

//ENVIRONMENT VARS
$envs = [
	"VANESSA_ENVIRONMENT" => "development",
	"VANESSA_SECRET" => bin2hex(openssl_random_pseudo_bytes(128))
];

if(!file_exists(VANESSA_STORAGE)) mkdir(VANESSA_STORAGE, 0775, true);

if(file_exists(VANESSA_STORAGE.'/.env')){
	exit("Already installed!\n");
}

file_put_contents(VANESSA_STORAGE.'/.env', join("\n", array_map(function($key, $value){
	return $key.'="'.$value.'"';
}, array_keys($envs), $envs)));

$dot = new \Symfony\Component\Dotenv\Dotenv();
$dot->load(VANESSA_STORAGE.'/.env');


//Generate user file
$settings = \Vanessa\Core\StorageFileHandler::openSecuredStorage(\Vanessa\Core\StorageFileHandler::SECURED_FILE_SETTINGS);
//Adding default user
\Vanessa\Core\User::create('administrator', 'administrator', 'superuser');

