<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Entity\Contact;
use App\Domain\Repository\ContactQueryRepositoryInterface;
use App\Domain\ValueObject\ContactId;
use RuntimeException;
use Throwable;

class GetContactInteractor
{
    private ContactQueryRepositoryInterface $queryRepo;

    public function __construct(
        ContactQueryRepositoryInterface $queryRepo
    ) {
        $this->queryRepo = $queryRepo;
    }

    public function action(ContactId $contactId): Contact
    {
        try {
            $contact = $this->queryRepo->getById($contactId);
        } catch (Throwable $e) {
            $errorMessage = $e->getMessage();
            if ($errorMessage === 'ContactNotFound') {
                throw new RuntimeException('ContactNotFound');
            }

            error_log($errorMessage);
            throw new RuntimeException('GetContactInfraError');
        }

        return $contact;
    }
}
