<?php

declare(strict_types=1);

namespace Tests\Presentation\Api\Controller;

use App\Presentation\Api\Controller\GetContact as GetContactController;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Factory\ResponseFactory;
use Tests\HttpTestTrait;
use Tests\Infrastructure\ContactCommandRepositoryTest;
use Tests\LoadEnvsTrait;

class GetContactTest extends TestCase
{
    use LoadEnvsTrait;
    use HttpTestTrait;

    private Response $response;

    public function setUp(): void
    {
        $this->loadEnvs();
        $this->response = (new ResponseFactory)->createResponse();
    }

    public function testGetContactWithId(): void
    {
        ContactCommandRepositoryTest::addDummyContact();

        $pathArgs = ["id" => 1];

        $getContactController = new GetContactController(
            $this->response,
            $pathArgs
        );
        $result = $getContactController->action();
        self::assertEquals(200, $result->getStatusCode());

        ContactCommandRepositoryTest::removeDummyContact();
    }
}
