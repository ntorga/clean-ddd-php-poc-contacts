<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Entity\Contact;
use App\Domain\Repository\ContactCommandRepositoryInterface;

class UpdateContactInteractor
{
    private ContactCommandRepositoryInterface $commandRepo;

    public function __construct(
        ContactCommandRepositoryInterface $commandRepo
    )
    {
        $this->commandRepo = $commandRepo;
    }

    public function action(Contact $updatedContact): bool
    {
        $this->commandRepo->removeContact($updatedContact->getId());
        $this->commandRepo->addContact(
            $updatedContact->getName(),
            $updatedContact->getNickname(),
            $updatedContact->getPhone()
        );
        return true;
    }
}
