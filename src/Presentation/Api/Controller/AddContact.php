<?php

declare(strict_types=1);

namespace App\Presentation\Api\Controller;

use App\Domain\Dto\AddContact as AddContactDto;
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

    public function action(): Response
    {
        $executionParams = $this->request->getParsedBody();
        $requiredParams = ['name', 'nickname', 'phone'];
        foreach ($requiredParams as $param) {
            if (!isset($executionParams[$param])) {
                $this->response->getBody()->write(
                    'Missing required parameter: ' . $param
                );
                return $this->response->withStatus(400);
            }
        }

        try {
            $addContactDto = new AddContactDto(
                new PersonName($executionParams['name']),
                new Nickname($executionParams['nickname']),
                new PhoneNumber($executionParams['phone']),
            );
        } catch (Throwable $th) {
            $this->response->getBody()->write($th->getMessage());
            return $this->response->withStatus(400);
        }

        $contactCommandRepo = new ContactCommandRepository();
        $addContact = new AddContactInteractor($contactCommandRepo);

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
