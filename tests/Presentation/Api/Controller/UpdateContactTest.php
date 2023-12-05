<?php

declare(strict_types=1);

namespace Tests\Presentation\Api\Controller;

use App\Presentation\Api\Controller\UpdateContactController;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Tests\HttpTestTrait;
use Tests\InteractorTrait;
use Tests\LoadEnvsTrait;

class UpdateContactControllerTest extends TestCase
{
    use LoadEnvsTrait;
    use HttpTestTrait;
    use InteractorTrait;

    private ServerRequestInterface $request;
    private Response $response;

    public function setUp(): void
    {
        $this->loadEnvs();
        $executionParams = [
            "name" => "Raymond Stantz",
            "nickname" => "Raymond",
            "phone" => "555-2368"
        ];
        $psr17ServerRequestFactory = $this->createRequest(
            'PUT',
            '/v1/contact'
        );
        $this->request = $this->withJson($psr17ServerRequestFactory, $executionParams);
        $this->response = (new ResponseFactory)->createResponse();
    }

    public function testUpdateContact(): void
    {
        $this->addContact();
        $args = ["id" => 1];

        $updateContact = new UpdateContactController(
            $this->request,
            $this->response,
            $args
        );
        $result = $updateContact->action();
        self::assertEquals(200, $result->getStatusCode());

        $this->removeContact();
    }
}