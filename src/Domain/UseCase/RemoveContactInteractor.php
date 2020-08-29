<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Repository\ContactCommandRepositoryInterface;
use App\Domain\ValueObject\ContactId;
use RuntimeException;
use Throwable;

class RemoveContactInteractor
{
    private ContactCommandRepositoryInterface $commandRepo;

    public function __construct(
        ContactCommandRepositoryInterface $commandRepo
    )
    {
        $this->commandRepo = $commandRepo;
    }

    public function action(ContactId $contactId): void
    {
        try {
            $this->commandRepo->removeContact($contactId);
        } catch (Throwable $th) {
            throw new RuntimeException(
                'Unable to remove contact: ' . $th->getMessage()
            );
        }
    }
}
