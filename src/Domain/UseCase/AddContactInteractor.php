<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

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
    )
    {
        $this->commandRepo = $commandRepo;
    }

    public function action(
        PersonName $name,
        Nickname $nickname,
        PhoneNumber $phone
    ): void
    {
        try {
            $this->commandRepo->addContact(
                $name,
                $nickname,
                $phone
            );
        } catch (Throwable $e) {
            throw new RuntimeException('Unable to create contact.');
        }
    }
}
