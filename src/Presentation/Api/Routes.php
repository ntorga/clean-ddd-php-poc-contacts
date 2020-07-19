<?php

declare(strict_types=1);

namespace App\Presentation\Api;

use Slim\App;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    /**
     * Slim4 recommended options for handling CORS.
     * @source http://www.slimframework.com/docs/v4/cookbook/enable-cors.html
     */
    $app->options('/{routes:.+}', function (Request $request, Response $response) {
        return $response;
    });

    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, HEAD, OPTIONS');
    });

    $app->group('/v1/contact', function (RouteCollectorProxy $group) {
        $group->get('/', function (Request $request, Response $response): Response {
        });

        $group->post('/', function (Request $request, Response $response): Response {
            return (new Controller\AddContactController($request, $response))->action();
        });

        $group->get('/{id:[0-9]+}', function (
            Request $request,
            Response $response,
            array $args
        ): Response {
        });

        $group->put('/{id:[0-9]+}', function (
            Request $request,
            Response $response,
            array $args
        ): Response {
        });

        $group->delete('/{id:[0-9]+}', function (
            Request $request,
            Response $response,
            array $args
        ): Response {
        });
    });

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: make sure this route is defined last
     * @source http://www.slimframework.com/docs/v4/cookbook/enable-cors.html
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function (Request $request): Response {
            throw new HttpNotFoundException($request);
        }
    );
};
