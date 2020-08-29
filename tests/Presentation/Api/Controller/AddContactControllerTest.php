<?php

declare(strict_types=1);

namespace Tests\Presentation\Api\Controller;

use App\Domain\UseCase\RemoveContactInteractor;
use App\Domain\ValueObject\ContactId;
use App\Infrastructure\ContactCommandRepository;
use App\Presentation\Api\Controller\AddContactController;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Tests\HttpTestTrait;
use Tests\LoadEnvsTrait;

class AddContactControllerTest extends TestCase
{
    use LoadEnvsTrait;
    use HttpTestTrait;

    private ServerRequestInterface $request;
    private Response $response;

    public function setUp(): void
    {
        $this->loadEnvs();
        $executionParams = [
            "name" => "John Doe",
            "nickname" => "John",
            "phone" => "555-2368"
        ];
        $psr17ServerRequestFactory = $this->createRequest(
            'POST',
            '/v1/contact'
        );
        $this->request = $this->withJson($psr17ServerRequestFactory, $executionParams);
        $this->response = (new ResponseFactory)->createResponse();
    }

    public function testAddContact(): void
    {
        $addContact = new AddContactController(
            $this->request,
            $this->response
        );
        $result = $addContact->action();
        self::assertEquals(200, $result->getStatusCode());
        $commandRepo = new ContactCommandRepository();
        $removeContact = new RemoveContactInteractor($commandRepo);
        $removeContact->action(new ContactId(1));
    }
}