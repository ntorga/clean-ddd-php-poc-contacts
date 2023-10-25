<?php

declare(strict_types=1);

namespace App\Presentation\Api\Controller;

use App\Domain\UseCase\RemoveContact as RemoveContactUseCase;
use App\Domain\ValueObject\ContactId;
use App\Infrastructure\ContactCommandRepository;
use App\Infrastructure\ContactQueryRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

class RemoveContact
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
        $commandRepo = new ContactCommandRepository();
        $removeContact = new RemoveContactUseCase($queryRepo, $commandRepo);

        try {
            $removeContact->action($contactId);
        } catch (Throwable $th) {
            $errorMessage = $th->getMessage();
            $statusCode = 500;
            if ($errorMessage === 'ContactNotFound') {
                $statusCode = 404;
            }

            $this->response->getBody()->write($errorMessage);
            return $this->response->withStatus($statusCode);
        }

        $this->response->getBody()->write('ContactRemoved');
        return $this->response->withStatus(200);
    }
}
