<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 10:11
 */


$app->map(["GET", "POST"], "/login", \Vanessa\Controllers\LoginController::class . ':login')->setName('vanessa:login');
$app->get("/logout", \Vanessa\Controllers\LoginController::class . ':logout')->setName("vanessa:logout");

$app->group('/auth', function (\Slim\App $app) {
	$app->get('/start', \Vanessa\Controllers\StartController::class . ':start')->setName("vanessa:start");

	//Templates
	$app->group("/template", function (\Slim\App $app) {
		$app->get("/all", \Vanessa\Controllers\TemplateController::class . ':listTemplates')->setName("vanessa:templates:list");
		$app->get("/add", \Vanessa\Controllers\TemplateController::class . ':addTemplate')->setName("vanessa:template:add");
		$app->map(['GET', 'POST'], "/edit/{template}", \Vanessa\Controllers\TemplateController::class . ':editTemplate')->setName("vanessa:template:edit");
	});
});