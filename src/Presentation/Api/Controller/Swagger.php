<?php

declare(strict_types=1);

namespace App\Presentation\Api\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *   title="Contact Manager API",
 *   description="A simple contact manager API to demonstrate the concepts
 *   of Clean Architecture and DDD with PHP 8.2+.",
 *   version="1.1",
 *   @OA\Contact(
 *     email="northontorga+github@gmail.com"
 *   ),
 *   @OA\License(
 *     name="Apache 2.0",
 *     url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *   )
 * )
 * 
 * @OA\Server(
 *   url="https://myproductionserver.com",
 *   description="Production server"
 * )
 * @OA\Server(
 *   url="http://localhost",
 *   description="Development environment"
 * )
 * 
 * @OA\Tag(
 *   name="contact",
 *   description="Operations about Contacts"
 * )
 */
class Swagger
{
    private Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function action(): Response
    {
        $swaggerContent = @file_get_contents(__DIR__ . '/../swagger.json');
        if ($swaggerContent === false || empty($swaggerContent)) {
            return $this->response->withStatus(404, 'SwaggerFileNotFound');
        }

        $this->response->getBody()->write($swaggerContent);
        return $this->response->withHeader('Content-Type', 'application/json');
    }
}
