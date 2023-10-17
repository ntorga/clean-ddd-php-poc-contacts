<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Dto\AddContact as AddContactDto;
use App\Domain\Repository\ContactCommandRepositoryInterface;
use RuntimeException;
use Throwable;

class AddContact
{
    private ContactCommandRepositoryInterface $commandRepo;

    public function __construct(
        ContactCommandRepositoryInterface $commandRepo
    ) {
        $this->commandRepo = $commandRepo;
    }

    public function action(AddContactDto $addContact): void
    {
        try {
            $this->commandRepo->add($addContact);
        } catch (Throwable $th) {
            error_log($th->getMessage());
            throw new RuntimeException('AddContactInfraError');
        }
    }
}
