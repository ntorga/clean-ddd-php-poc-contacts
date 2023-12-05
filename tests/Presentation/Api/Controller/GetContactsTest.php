<?php

declare(strict_types=1);

namespace Tests\Presentation\Api\Controller;

use App\Presentation\Api\Controller\GetContacts as GetContactsController;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Factory\ResponseFactory;
use Tests\HttpTestTrait;
use Tests\Infrastructure\ContactCommandRepositoryTest;
use Tests\LoadEnvsTrait;

class GetContactsTest extends TestCase
{
    use LoadEnvsTrait;
    use HttpTestTrait;

    private Response $response;

    public function setUp(): void
    {
        $this->loadEnvs();
        $this->response = (new ResponseFactory)->createResponse();
    }

    public function testGetContacts(): void
    {
        ContactCommandRepositoryTest::addDummyContact();

        $getContactsController = new GetContactsController(
            $this->response
        );
        $result = $getContactsController->action();
        self::assertEquals(200, $result->getStatusCode());

        ContactCommandRepositoryTest::removeDummyContact();
    }
}
