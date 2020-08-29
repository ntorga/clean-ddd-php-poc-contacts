<?php

declare(strict_types=1);

namespace App\Presentation\Api\Middleware;

use JsonException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Factory\StreamFactory;

class JsonResponseMiddleware
{
    public function __invoke(
        Request $request,
        RequestHandler $handler
    ): ResponseInterface
    {
        $response = $handler->handle($request);

        try {
            $originalBody = json_decode(
                (string)$response->getBody(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            $originalBody = (string)$response->getBody();
        }

        try {
            $newBody = json_encode($originalBody, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return $response;
        }

        $modifiedResponse = $response->withBody(
            (new StreamFactory())->createStream($newBody)
        );
        return $modifiedResponse->withHeader('Content-Type', 'application/json');
    }
}
