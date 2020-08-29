<?php

declare(strict_types=1);

namespace App\Presentation\Api\Controller;

use App\Domain\UseCase\GetContactsInteractor;
use App\Infrastructure\ContactQueryRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

class GetContactsController
{
    private Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function action(): Response
    {
        $queryRepo = new ContactQueryRepository();
        $getContacts = new GetContactsInteractor($queryRepo);

        try {
            $contacts = json_encode($getContacts->action(), JSON_THROW_ON_ERROR);
        } catch (Throwable $th) {
            $this->response->getBody()->write($th->getMessage());
            return $this->response->withStatus(500);
        }

        $this->response->getBody()->write($contacts);
        return $this->response->withStatus(200);
    }
}
