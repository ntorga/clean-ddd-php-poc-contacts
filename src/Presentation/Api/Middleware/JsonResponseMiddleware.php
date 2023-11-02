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
    ): ResponseInterface {
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

        $responseCode = $response->getStatusCode();

        try {
            $encodedOriginalBody = json_encode($originalBody, JSON_THROW_ON_ERROR);
            $encodedNewBody = json_encode([
                "status" => $responseCode,
                "body" => $encodedOriginalBody,
            ]);
        } catch (JsonException $e) {
            return $response;
        }

        $newResponseBody = (new StreamFactory())->createStream($encodedNewBody);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withBody($newResponseBody);
    }
}
