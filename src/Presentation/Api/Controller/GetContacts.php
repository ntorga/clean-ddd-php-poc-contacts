<?php

declare(strict_types=1);

namespace App\Presentation\Api\Controller;

use App\Domain\UseCase\GetContacts as GetContactsUseCase;
use App\Infrastructure\ContactQueryRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

class GetContacts
{
    private Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function action(): Response
    {
        $queryRepo = new ContactQueryRepository();
        $getContacts = new GetContactsUseCase($queryRepo);

        try {
            $contactEntities = $getContacts->action();
        } catch (Throwable $th) {
            $this->response->getBody()->write($th->getMessage());
            return $this->response->withStatus(500);
        }

        $encodedEntities = json_encode($contactEntities, JSON_THROW_ON_ERROR);

        $this->response->getBody()->write($encodedEntities);
        return $this->response->withStatus(200);
    }
}
