<?php

declare(strict_types=1);

namespace App\Presentation\Api\Controller;

use App\Domain\Dto\UpdateContact as UpdateContactDto;
use App\Domain\UseCase\UpdateContact as UpdateContactUseCase;
use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use App\Infrastructure\ContactCommandRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Throwable;

class UpdateContact
{
    private Request $request;
    private Response $response;

    public function __construct(
        Request $request,
        Response $response,
    ) {
        $this->request = $request;
        $this->response = $response;
    }

    public function action(): Response
    {
        $executionParams = $this->request->getParsedBody();
        $requiredParams = ['id'];
        foreach ($requiredParams as $param) {
            if (!isset($executionParams[$param])) {
                $this->response->getBody()->write(
                    'MissingRequiredParameter: ' . $param
                );
                return $this->response->withStatus(400);
            }
        }

        try {
            $personName = null;
            if (isset($executionParams['name'])) {
                $personName = new PersonName($executionParams['name']);
            }

            $nickname = null;
            if (isset($executionParams['nickname'])) {
                $nickname = new Nickname($executionParams['nickname']);
            }

            $phoneNumber = null;
            if (isset($executionParams['phone'])) {
                $phoneNumber = new PhoneNumber($executionParams['phone']);
            }

            $updateContactDto = new UpdateContactDto(
                new ContactId((int)$executionParams['id']),
                $personName,
                $nickname,
                $phoneNumber
            );
        } catch (Throwable $th) {
            $this->response->getBody()->write($th->getMessage());
            return $this->response->withStatus(400);
        }

        $contactCommandRepo = new ContactCommandRepository();
        $updateContact = new UpdateContactUseCase($contactCommandRepo);

        try {
            $updateContact->action($updateContactDto);
        } catch (Throwable $th) {
            $this->response->getBody()->write($th->getMessage());
            return $this->response->withStatus(500);
        }

        $this->response->getBody()->write('ContactUpdated');
        return $this->response->withStatus(200);
    }
}
