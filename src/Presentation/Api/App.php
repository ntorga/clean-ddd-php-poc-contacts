<?php

declare(strict_types=1);

require __DIR__ . '/../../../vendor/autoload.php';

use App\Presentation\Api\Middleware\JsonResponseMiddleware;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

$dotenv = Dotenv::createImmutable(__DIR__ . "/../../../config", '.env');
$dotenv->load();

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

$routes = require __DIR__ . '/Routes.php';
$routes($app);

$app->add(new JsonResponseMiddleware());

$app->run();
