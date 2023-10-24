<?php

declare(strict_types=1);

namespace App\Presentation\Api\Controller;

use App\Domain\UseCase\GetContact as GetContactUseCase;
use App\Domain\ValueObject\ContactId;
use App\Infrastructure\ContactQueryRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

class GetContact
{
    private Response $response;
    private array $args;

    public function __construct(
        Response $response,
        array $args
    ) {
        $this->response = $response;
        $this->args = $args;
    }

    public function action(): Response
    {
        try {
            $contactId = new ContactId((int)$this->args["id"]);
        } catch (Throwable $th) {
            $this->response->getBody()->write($th->getMessage());
            return $this->response->withStatus(400);
        }

        $queryRepo = new ContactQueryRepository();
        $getContact = new GetContactUseCase($queryRepo);

        try {
            $contactEntity = $getContact->action($contactId);
        } catch (Throwable $th) {
            $this->response->getBody()->write($th->getMessage());
            return $this->response->withStatus(500);
        }

        $encodedEntity = json_encode(
            $contactEntity,
            JSON_THROW_ON_ERROR
        );
        $this->response->getBody()->write($encodedEntity);
        return $this->response->withStatus(200);
    }
}
