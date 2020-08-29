<?php

declare(strict_types=1);

namespace Tests\Presentation\Api\Controller;

use App\Presentation\Api\Controller\GetContactsController;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Factory\ResponseFactory;
use Tests\HttpTestTrait;
use Tests\InteractorTrait;
use Tests\LoadEnvsTrait;

class GetContactsControllerTest extends TestCase
{
    use LoadEnvsTrait;
    use HttpTestTrait;
    use InteractorTrait;

    private Response $response;

    public function setUp(): void
    {
        $this->loadEnvs();
        $this->response = (new ResponseFactory)->createResponse();
    }

    public function testRemoveContact(): void
    {
        $this->addContact();

        $getContactsController = new GetContactsController(
            $this->response
        );
        $result = $getContactsController->action();
        self::assertEquals(200, $result->getStatusCode());

        $this->removeContact();
    }
}