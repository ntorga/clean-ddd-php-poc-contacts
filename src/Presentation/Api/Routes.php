<?php

declare(strict_types=1);

namespace App\Presentation\Api;

use App\Presentation\Api\Controller\AddContact;
use App\Presentation\Api\Controller\GetContact;
use App\Presentation\Api\Controller\GetContacts;
use App\Presentation\Api\Controller\RemoveContact;
use App\Presentation\Api\Controller\UpdateContact;
use App\Presentation\Api\Controller\Swagger;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app) {
    /**
     * Slim4 recommended options for handling CORS.
     * @source http://www.slimframework.com/docs/v4/cookbook/enable-cors.html
     */
    $app->options('/{routes:.+}', static function (
        Request $request,
        Response $response
    ) {
        return $response;
    });

    $app->add(static function ($request, $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader(
                'Access-Control-Allow-Headers',
                'X-Requested-With, Content-Type, Accept, Origin, Authorization',
            )
            ->withHeader(
                'Access-Control-Allow-Methods',
                'GET, POST, PUT, DELETE, HEAD, OPTIONS',
            );
    });

    $app->get('/swagger.json', static function (
        Request $request,
        Response $response
    ): Response {
        return (new Swagger($response))->action();
    });

    $app->group('/v1/contact', static function (RouteCollectorProxy $group) {
        $group->get('', static function (
            Request $request,
            Response $response
        ): Response {
            return (new GetContacts($response))->action();
        });

        $group->get('/{id:[0-9]+}', static function (
            Request $request,
            Response $response,
            array $args
        ): Response {
            return (new GetContact($response, $args))->action();
        });

        $group->post('', static function (
            Request $request,
            Response $response
        ): Response {
            return (new AddContact($request, $response))->action();
        });

        $group->put('/{id:[0-9]+}', static function (
            Request $request,
            Response $response,
            array $args
        ): Response {
            return (new UpdateContact($request, $response, $args))->action();
        });

        $group->delete('/{id:[0-9]+}', static function (
            Request $request,
            Response $response,
            array $args
        ): Response {
            return (new RemoveContact($response, $args))->action();
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
        function ($request, $response) {
            return $response->withStatus(404, 'RouteNotFound');
        }
    );
};
