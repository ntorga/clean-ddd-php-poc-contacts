<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Repository\ContactCommandRepositoryInterface;
use App\Domain\Repository\ContactQueryRepositoryInterface;
use App\Domain\ValueObject\ContactId;
use DomainException;
use RuntimeException;
use Throwable;

class RemoveContact
{
    private ContactQueryRepositoryInterface $queryRepo;
    private ContactCommandRepositoryInterface $commandRepo;

    public function __construct(
        ContactQueryRepositoryInterface $queryRepo,
        ContactCommandRepositoryInterface $commandRepo
    ) {
        $this->queryRepo = $queryRepo;
        $this->commandRepo = $commandRepo;
    }

    public function action(ContactId $contactId): void
    {
        $getContact = new GetContact($this->queryRepo);
        try {
            $getContact->action($contactId);
        } catch (Throwable $th) {
            throw new DomainException('ContactNotFound');
        }

        try {
            $this->commandRepo->remove($contactId);
        } catch (Throwable $th) {
            error_log($th->getMessage());
            throw new RuntimeException('RemoveContactInfraError');
        }
    }
}
