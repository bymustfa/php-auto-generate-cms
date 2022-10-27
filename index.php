<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();

require __DIR__ . '/vendor/autoload.php';

date_default_timezone_set(config('TIMEZONE', 'Europe/Istanbul'));


$app = new \Core\Bootstrap();

define('BASE_URL', config('BASE_URL'));

require __DIR__ . '/App/Routes/index.php';


$app->run();

?>
