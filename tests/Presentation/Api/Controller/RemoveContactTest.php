<?php

declare(strict_types=1);

namespace Tests\Presentation\Api\Controller;

use App\Presentation\Api\Controller\RemoveContactController;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Factory\ResponseFactory;
use Tests\HttpTestTrait;
use Tests\InteractorTrait;
use Tests\LoadEnvsTrait;

class RemoveContactControllerTest extends TestCase
{
    use LoadEnvsTrait;
    use HttpTestTrait;
    use InteractorTrait;

    private Response $response;
    private array $args;

    public function setUp(): void
    {
        $this->loadEnvs();
        $this->args = ["id" => 1];
        $this->response = (new ResponseFactory)->createResponse();
    }

    public function testRemoveContact(): void
    {
        $this->addContact();

        $removeContactController = new RemoveContactController(
            $this->response,
            $this->args
        );
        $result = $removeContactController->action();
        self::assertEquals(200, $result->getStatusCode());

        $this->removeContact();
    }
}