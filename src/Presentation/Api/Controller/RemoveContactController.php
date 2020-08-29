<?php

declare(strict_types=1);

namespace App\Presentation\Api\Controller;

use App\Domain\UseCase\RemoveContactInteractor;
use App\Domain\ValueObject\ContactId;
use App\Infrastructure\ContactCommandRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

class RemoveContactController
{
    private Response $response;
    private array $args;

    public function __construct(
        Response $response,
        array $args
    )
    {
        $this->response = $response;
        $this->args = $args;
    }

    private function getContactId(): ContactId
    {
        return new ContactId($this->args["id"]);
    }

    public function action(): Response
    {
        $contactCommandRepo = new ContactCommandRepository();
        $removeContact = new RemoveContactInteractor($contactCommandRepo);

        try {
            $removeContact->action($this->getContactId());
        } catch (Throwable $th) {
            $this->response->getBody()->write($th->getMessage());
            return $this->response->withStatus(400);
        }

        $this->response->getBody()->write('Contact removed successfully!');
        return $this->response->withStatus(200);
    }
}
