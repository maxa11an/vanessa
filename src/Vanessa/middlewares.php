<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 10:11
 */


$app->add(\Vanessa\Middlewares\BaseMiddleware::class);

$app->add(\Vanessa\Middlewares\AuthMiddleware::class);


