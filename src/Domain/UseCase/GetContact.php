<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Entity\Contact;
use App\Domain\Repository\ContactQueryRepositoryInterface;
use App\Domain\ValueObject\ContactId;
use RuntimeException;
use Throwable;

class GetContact
{
    public function __construct(
        private ContactQueryRepositoryInterface $queryRepo
    ) {}

    public function action(ContactId $contactId): Contact
    {
        try {
            $contact = $this->queryRepo->getById($contactId);
        } catch (Throwable $th) {
            $errorMessage = $th->getMessage();
            if ($errorMessage === 'ContactNotFound') {
                throw new RuntimeException('ContactNotFound');
            }

            error_log($errorMessage);
            throw new RuntimeException('GetContactInfraError');
        }

        return $contact;
    }
}
