<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Repository\ContactCommandRepositoryInterface;
use App\Domain\Dto\UpdateContact as UpdateContactDto;
use RuntimeException;
use Throwable;

class UpdateContact
{
    public function __construct(
        private ContactCommandRepositoryInterface $commandRepo
    ) {}

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
