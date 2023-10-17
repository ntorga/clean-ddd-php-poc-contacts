<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Repository\ContactCommandRepositoryInterface;
use App\Domain\Dto\UpdateContact as UpdateContactDto;
use RuntimeException;
use Throwable;

class UpdateContact
{
    private ContactCommandRepositoryInterface $commandRepo;

    public function __construct(
        ContactCommandRepositoryInterface $commandRepo
    ) {
        $this->commandRepo = $commandRepo;
    }

    public function action(UpdateContactDto $updatedContact): void
    {
        try {
            $this->commandRepo->update($updatedContact);
        } catch (Throwable $th) {
            error_log($th->getMessage());
            throw new RuntimeException('UpdateContactInfraError');
        }
    }
}
