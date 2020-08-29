<?php

namespace Tests;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\StreamFactory;

/**
 * This trait is used to create PSR-7 objects used by the controllers unit tests.
 * @source https://raw.githubusercontent.com/odan/slim4-skeleton/master/tests/TestCase/HttpTestTrait.php
 */
trait HttpTestTrait
{
    protected function createRequest(
        string $method,
        string $uri,
        array $serverParams = []
    ): ServerRequestInterface
    {
        // A phpunit fix #3026
        if (!isset($_SERVER['REQUEST_URI'])) {
            $_SERVER = [
                'SCRIPT_NAME' => '/src/Presentation/Api/App.php',
                'REQUEST_TIME_FLOAT' => microtime(true),
                'REQUEST_TIME' => (int)microtime(true),
            ];
        }

        $factory = new ServerRequestFactory();

        return $factory->createServerRequest($method, $uri, $serverParams);
    }

    private function createStream(string $content): StreamInterface
    {
        $streamFactory = new StreamFactory();
        return $streamFactory->createStream($content);
    }

    protected function withJson(
        ServerRequestInterface $request,
        array $data
    ): ServerRequestInterface
    {
        $request = $request->withParsedBody($data);
        $request = $request->withBody($this->createStream(
            json_encode($data, JSON_THROW_ON_ERROR))
        );

        return $request->withHeader('Content-Type', 'application/json');
    }
}
