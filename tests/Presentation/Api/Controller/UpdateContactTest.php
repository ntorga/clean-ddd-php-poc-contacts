<?php

declare(strict_types=1);

namespace Tests\Presentation\Api\Controller;

use App\Presentation\Api\Controller\UpdateContact as UpdateContactController;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Factory\ResponseFactory;
use Tests\HttpTestTrait;
use Tests\Infrastructure\ContactCommandRepositoryTest;
use Tests\LoadEnvsTrait;

class UpdateContactTest extends TestCase
{
    use LoadEnvsTrait;
    use HttpTestTrait;

    private Response $response;

    public function setUp(): void
    {
        $this->loadEnvs();
        $this->response = (new ResponseFactory)->createResponse();
    }

    public function testUpdateContact(): void
    {
        $executionParams = [
            "id" => 1,
            "name" => "Raymond Stantz",
            "nickname" => "Raymond",
            "phone" => "555-2368"
        ];
        $psr17ServerRequestFactory = $this->createRequest(
            'PUT',
            '/v1/contact'
        );
        $request = $this->withJson(
            $psr17ServerRequestFactory,
            $executionParams,
        );

        ContactCommandRepositoryTest::addDummyContact();

        $updateContact = new UpdateContactController(
            $request,
            $this->response,
        );
        $result = $updateContact->action();
        self::assertEquals(200, $result->getStatusCode());

        ContactCommandRepositoryTest::removeDummyContact();
    }
}
