<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 10:11
 */


$container = $app->getContainer();

$container['view'] = function ($container) {
	$view = new \Slim\Views\Twig(__DIR__ . '/../../src/Vanessa/Views', [

	]);
	// Instantiate and add Slim specific extension
	$router = $container->get('router');
	$uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
	$view->addExtension(new \Slim\Views\TwigExtension($router, $uri));
	$view->addExtension(new \Vanessa\Core\Twig\Extension\Localization());


	$view->addExtension(new \Knlv\Slim\Views\TwigMessages(
		new \Slim\Flash\Messages()
	));

	return $view;
};

$container['flash'] = function () {
	return new \Slim\Flash\Messages();
};