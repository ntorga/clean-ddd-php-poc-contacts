<?php

declare(strict_types=1);

namespace App\Presentation\Api\Controller;

use App\Domain\UseCase\AddContactInteractor;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use App\Infrastructure\ContactCommandRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Throwable;

class AddContact
{
    private Request $request;
    private Response $response;

    public function __construct(
        Request $request,
        Response $response
    ) {
        $this->request = $request;
        $this->response = $response;
    }

    private function getExecutionParams(): array
    {
        $executionParams = $this->request->getParsedBody();
        return [
            "name" => new PersonName($executionParams['name']),
            "nickname" => new Nickname($executionParams['nickname']),
            "phone" => new PhoneNumber($executionParams['phone'])
        ];
    }

    public function action(): Response
    {
        $contactCommandRepo = new ContactCommandRepository();
        $addContact = new AddContactInteractor($contactCommandRepo);

        try {
            $params = $this->getExecutionParams();
        } catch (Throwable $th) {
            $this->response->getBody()->write($th->getMessage());
            return $this->response->withStatus(400);
        }

        try {
            $addContact->action(
                $params['name'],
                $params['nickname'],
                $params['phone']
            );
        } catch (Throwable $th) {
            $this->response->getBody()->write(
                'Contact creation failed: ' . $th->getMessage()
            );
            return $this->response->withStatus(500);
        }

        $this->response->getBody()->write(
            'Contact created successfully!'
        );
        return $this->response->withStatus(200);
    }
}
