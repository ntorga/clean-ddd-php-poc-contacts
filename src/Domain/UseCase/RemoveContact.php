<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Repository\ContactCommandRepositoryInterface;
use App\Domain\ValueObject\ContactId;
use RuntimeException;
use Throwable;

class RemoveContact
{
    private ContactCommandRepositoryInterface $commandRepo;

    public function __construct(
        ContactCommandRepositoryInterface $commandRepo
    ) {
        $this->commandRepo = $commandRepo;
    }

    public function action(ContactId $contactId): void
    {
        try {
            $this->commandRepo->remove($contactId);
        } catch (Throwable $th) {
            error_log($th->getMessage());
            throw new RuntimeException('RemoveContactInfraError');
        }
    }
}
