<?php

declare(strict_types=1);

namespace App\Presentation\Api;

use App\Presentation\Api\Controller\AddContactController;
use App\Presentation\Api\Controller\GetContactController;
use App\Presentation\Api\Controller\GetContactsController;
use App\Presentation\Api\Controller\RemoveContactController;
use App\Presentation\Api\Controller\UpdateContactController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
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
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, HEAD, OPTIONS');
    });

    $app->group('/v1/contact', static function (RouteCollectorProxy $group) {
        $group->get('', static function (
            Request $request,
            Response $response
        ): Response {
            return (new GetContactsController($response))->action();
        });

        $group->post('', static function (
            Request $request,
            Response $response
        ): Response {
            return (new AddContactController($request, $response))->action();
        });

        $group->get('/{id:[0-9]+}', static function (
            Request $request,
            Response $response,
            array $args
        ): Response {
            return (new GetContactController($response, $args))->action();
        });

        $group->put('/{id:[0-9]+}', static function (
            Request $request,
            Response $response,
            array $args
        ): Response {
            return (new UpdateContactController(
                $request,
                $response,
                $args
            ))->action();
        });

        $group->delete('/{id:[0-9]+}', static function (
            Request $request,
            Response $response,
            array $args
        ): Response {
            return (new RemoveContactController($response, $args))->action();
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
        static function (Request $request): Response {
            throw new HttpNotFoundException($request);
        }
    );
};
