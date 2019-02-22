<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-22
 * Time: 09:17
 */

$controllerRootPath = __DIR__ . "/../front-end/admin/controllers/";
$twigRootPath = __DIR__ . '/../front-end/admin/views/';

$opts = [
	"name" => null,
	"path" => "",
	"noTwig" => false
];

if($argv[1] == "exit"){
	exit;
}

foreach ($argv as $arg) {
	if (strpos($arg, "=") !== FALSE) {
		$args = explode("=", $arg);
		$opts[trim($args[0])] = trim($args[1]);
	}
	if ($arg == "noTwig") {
		$opts['noTwig'] = true;
	}
}

if (strpos($opts['name'], '/') !== FALSE) {
	$opts['path'] = strtolower(join("/", array_slice(explode("/", $opts['name']), 0, -1)));
	$opts['name'] = strtolower(end(explode("/", $opts['name'])));
	if(!file_exists($controllerRootPath . $opts['path'])){
		mkdir($controllerRootPath . $opts['path'], 0777, true);
	}
}

$phpClass = '<?php
/**
 * Date: ' . date("Y-m-d") . '
 * Time: ' . date("h:m") . '
 */

namespace Vanessa\Admin\controllers' . ($opts['path'] !== "" ? "\\" . str_replace('/', '\\', $opts['path']) : "") . ';

use Slim\Http\Request;
use Slim\Http\Response;

class ' . ucfirst($opts['name']) . 'Controller extends \Vanessa\Admin\controllers\BaseController
{

	public function '.$opts['name'].'(Request $request, Response $response, array $args)
	{
		return $this->view()->render($response, "' . ($opts['path'] !== "" ? $opts['path'] . '/' : "").$opts['name'] . '.twig");
	}

}';

if(file_exists($controllerRootPath . ($opts['path'] != "" ? $opts['path'] . '/' : "") . ucfirst($opts['name']) . 'Controller.php')){
	throw new Exception("Controller Already Exists");
}


file_put_contents($controllerRootPath . ($opts['path'] != "" ? $opts['path'] . '/' : "") . ucfirst($opts['name']) . 'Controller.php', $phpClass);
chmod($controllerRootPath . ($opts['path'] != "" ? $opts['path'] . '/' : "") . ucfirst($opts['name']) . 'Controller.php', 0644);

if ($opts['noTwig'] !== false) {
	exit;
}

if ($opts['path'] != "") {
	if(!file_exists($twigRootPath . $opts['path'])){
		mkdir($twigRootPath . $opts['path'], 0777, true);
	}
}

$twigFile = '
{# 
 # Date: '.date('Y-m-d').'
 # Time: '.date('h:m').'     
 #}
{% extends "_main.twig" %}

{% block content %}



{% endblock %}';

file_put_contents($twigRootPath . ($opts['path'] != "" ? $opts['path'] . '/' : "") . $opts['name'] . '.twig', $twigFile);
chmod($twigRootPath . ($opts['path'] != "" ? $opts['path'] . '/' : "") . $opts['name'] . '.twig', 0644);