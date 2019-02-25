<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 10:11
 */



$app->map(["GET", "POST"], "/login", \Vanessa\Controllers\LoginController::class . ':login')->setName('vanessa:login');
$app->get("/logout", \Vanessa\Controllers\LoginController::class . ':logout')->setName("vanessa:logout");

$app->group('/auth', function(\Slim\App $app){
	$app->get('/start', \Vanessa\Controllers\StartController::class.':start')->setName("vanessa:start");
});