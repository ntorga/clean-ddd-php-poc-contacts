<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Dto\AddContact;
use App\Domain\Repository\ContactCommandRepositoryInterface;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use RuntimeException;
use Throwable;

class AddContactInteractor
{
    private ContactCommandRepositoryInterface $commandRepo;

    public function __construct(
        ContactCommandRepositoryInterface $commandRepo
    ) {
        $this->commandRepo = $commandRepo;
    }

    public function action(AddContact $addContact): void
    {
        try {
            $this->commandRepo->addContact($addContact);
        } catch (Throwable $e) {
            error_log($e->getMessage());
            throw new RuntimeException('AddContactInfraError');
        }
    }
}
