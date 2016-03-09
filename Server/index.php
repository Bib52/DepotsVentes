<?php

require 'vendor/autoload.php';

$app = new Slim\App;

require 'app/routes.php';
$app->run();