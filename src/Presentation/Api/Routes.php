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

    /**
     * @OA\Info(
     *   title="Contact Manager API", version="1.0",
     *   description="A simple contact manager API to demonstrate the concepts
    of Clean Architecture and DDD with PHP 7.4+.",
     *   version="1.0",
     *   @OA\Contact(
     *     email="northontorga+github@gmail.com"
     *   ),
     *   @OA\License(
     *     name="Apache 2.0",
     *     url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *   )
     * )
     * @OA\Server(
     *   url="https://myproductionserver.com",
     *   description="Production server"
     * )
     * @OA\Server(
     *   url="https://localhost",
     *   description="Development environment"
     * )
     */

    /**
     * @OA\Tag(
     *    name="contact",
     *    description="Operations about Contacts",
     *    @OA\ExternalDocumentation(
     *      description="Find out more",
     *      url="https://ntorga.com"
     *    )
     *  )
     */

    $app->group('/v1/contact', static function (RouteCollectorProxy $group) {

        /**
         * @OA\Get(
         *   path="/v1/contact",
         *   tags={"contact"},
         *   @OA\Response(
         *     response="200",
         *     description="All contacts.",
         *     @OA\JsonContent(
         *       type="array",
         *       @OA\Items(ref="#/components/schemas/Contact")
         *     )
         *   )
         * )
         */
        $group->get('', static function (
            Request $request,
            Response $response
        ): Response {
            return (new GetContactsController($response))->action();
        });

        /**
         * @OA\Post(
         *   path="/v1/contact",
         *   tags={"contact"},
         *   requestBody={"$ref": "#/components/requestBodies/ContactBody"},
         *   @OA\Response(
         *      response="200",
         *      description="Contact created successfully!"
         *   )
         * )
         */
        $group->post('', static function (
            Request $request,
            Response $response
        ): Response {
            return (new AddContactController($request, $response))->action();
        });

        /**
         * @OA\Get(
         *   path="/v1/contact/{id}",
         *   @OA\Parameter(
         *     name="id",
         *     in="path",
         *     description="ID of the contact",
         *     required=true,
         *     @OA\Schema(
         *       type="integer",
         *       format="int32"
         *     )
         *   ),
         *   tags={"contact"},
         *   @OA\Response(
         *     response="200",
         *     description="Contact requested.",
         *     @OA\JsonContent(ref="#/components/schemas/Contact")
         *   )
         * )
         */
        $group->get('/{id:[0-9]+}', static function (
            Request $request,
            Response $response,
            array $args
        ): Response {
            return (new GetContactController($response, $args))->action();
        });

        /**
         * @OA\Put(
         *   path="/v1/contact/{id}",
         *   @OA\Parameter(
         *     name="id",
         *     in="path",
         *     description="ID of the contact",
         *     required=true,
         *     @OA\Schema(
         *       type="integer",
         *       format="int32"
         *     )
         *   ),
         *   tags={"contact"},
         *   requestBody={"$ref": "#/components/requestBodies/ContactBody"},
         *   @OA\Response(
         *      response="200",
         *      description="Contact updated successfully!"
         *   )
         * )
         */
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

        /**
         * @OA\Delete(
         *   path="/v1/contact/{id}",
         *   @OA\Parameter(
         *     name="id",
         *     in="path",
         *     description="ID of the contact",
         *     required=true,
         *     @OA\Schema(
         *       type="integer",
         *       format="int32"
         *     )
         *   ),
         *   tags={"contact"},
         *   @OA\Response(
         *      response="200",
         *      description="Contact removed successfully!"
         *   )
         * )
         */
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
