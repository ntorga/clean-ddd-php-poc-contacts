<?php

declare(strict_types=1);

namespace App\Presentation\Api\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Infrastructure\ContactCommandRepository;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use App\Domain\UseCase\AddContactInteractor;

class AddContactController
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
            "nick" => new Nickname($executionParams['nick']),
            "phone" => new PhoneNumber($executionParams['phone'])
        ];
    }

    public function action(): Response
    {
        $contactCommandRepo = new ContactCommandRepository();
        $addContact = new AddContactInteractor($contactCommandRepo);

        try {
            $params = $this->getExecutionParams();
            $contactId = $addContact->action(
                $params['name'],
                $params['nick'],
                $params['phone']
            );

            $this->response->getBody()->write(
                'User created successfully with ID "' . $contactId . '".'
            );
            $responseCode = 200;
        } catch (\Throwable $e) {
            $this->response->getBody()->write(
                'User creation failed!' . PHP_EOL
                    . 'Please verify if you sent a valid name, nick and phone.'
            );
            $responseCode = 400;
        }

        $finalResponse = $this->response->withStatus($responseCode);
        return $finalResponse;
    }
}
