<?php

declare(strict_types=1);

// Instantiate Composer.
require __DIR__ . '/../../../vendor/autoload.php';

use Slim\Factory\AppFactory;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../../config", '.env');
$dotenv->load();

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

// Register Routes.
$routes = require __DIR__ . '/Routes.php';
$routes($app);

// Run the app.
$app->run();
