<?php

declare(strict_types=1);

namespace App\Presentation\Api\Controller;

use App\Domain\Dto\AddContact as AddContactDto;
use App\Domain\UseCase\AddContact as AddContactUseCase;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use App\Infrastructure\ContactCommandRepository;
use App\Presentation\Api\Helper\MissingParamHelper;
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
        $requiredParams = ['name', 'nickname', 'phone'];
        $executionParams = $this->request->getParsedBody();
        try {
            MissingParamHelper::action($this->request, $requiredParams);

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
        $addContact = new AddContactUseCase($contactCommandRepo);

        try {
            $addContact->action($addContactDto);
        } catch (Throwable $th) {
            $this->response->getBody()->write($th->getMessage());
            return $this->response->withStatus(500);
        }

        $this->response->getBody()->write('ContactCreated');
        return $this->response->withStatus(201);
    }
}
