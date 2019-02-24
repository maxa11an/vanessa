<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-21
 * Time: 20:31
 */

require_once "./vendor/autoload.php";

/*print "To setup your environment you'll need to select a password for administrator: ";

system('stty -echo');
$password = trim(fgets(STDIN));
system('stty echo');

print "\nRepeat password: ";

system('stty -echo');
$password_repeat = trim(fgets(STDIN));
system('stty echo');

if ($password !== $password_repeat) {
	echo "\nThe password didn't match!\n";
	$password = NULL;
	$password_repeat = NULL;
	exit;
}*/

if(\Vanessa\User::create("administrator", "administrator")){
	echo "\nCreated administrator";
}
$filename = md5(time()).".html";
\Vanessa\NoSQL::open("pages")->insert([
	"url" => "/",
	"filename" => $filename
]);
mkdir(".pages");
file_put_contents(".pages/$filename", '<html><head><title>Index</title></head><body><h1>Hello world!</h1></body></html>');

echo "\nCreated start page";
exit;