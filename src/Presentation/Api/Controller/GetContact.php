<?php

declare(strict_types=1);

namespace App\Presentation\Api\Controller;

use App\Domain\UseCase\GetContactInteractor;
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

    private function getContactId(): ContactId
    {
        return new ContactId((int)$this->args["id"]);
    }

    public function action(): Response
    {
        $queryRepo = new ContactQueryRepository();
        $getContact = new GetContactInteractor($queryRepo);

        try {
            $contact = json_encode(
                $getContact->action($this->getContactId()),
                JSON_THROW_ON_ERROR
            );
        } catch (Throwable $th) {
            $this->response->getBody()->write($th->getMessage());
            return $this->response->withStatus(500);
        }

        $this->response->getBody()->write($contact);
        return $this->response->withStatus(200);
    }
}
