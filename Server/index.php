<?php
require_once 'vendor/autoload.php';

Configuration::config();
$app = new Slim\App;

require 'app/routes.php';

$app->run();

?>