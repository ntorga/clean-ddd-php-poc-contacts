<?php

declare(strict_types=1);

namespace Tests\Presentation\Api\Controller;

use App\Presentation\Api\Controller\AddContact as AddContactController;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Factory\ResponseFactory;
use Tests\HttpTestTrait;
use Tests\Infrastructure\ContactCommandRepositoryTest;
use Tests\LoadEnvsTrait;

class AddContactTest extends TestCase
{
    use LoadEnvsTrait;
    use HttpTestTrait;

    private Response $response;

    public function setUp(): void
    {
        $this->loadEnvs();
        $this->response = (new ResponseFactory)->createResponse();
    }

    public function testAddContact(): void
    {
        $executionParams = [
            "name" => "Egon Spengler",
            "nickname" => "Egon",
            "phone" => "555-2368"
        ];
        $psr17ServerRequestFactory = $this->createRequest(
            'POST',
            '/v1/contact'
        );
        $request = $this->withJson(
            $psr17ServerRequestFactory,
            $executionParams,
        );

        $addContact = new AddContactController(
            $request,
            $this->response
        );
        $result = $addContact->action();
        self::assertEquals(201, $result->getStatusCode());

        ContactCommandRepositoryTest::removeDummyContact();
    }
}
