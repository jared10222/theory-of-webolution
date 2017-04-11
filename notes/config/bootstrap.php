<?php
require_once("database.php");
require_once("site.php");
require_once("functions.php");
require_once("lib/livid/autoloader.php");
use livid\database\PdoDatabase;
use livid\router\Router;

$db = new PdoDatabase;
$router = new Router;
require_once("routes.php");
?>