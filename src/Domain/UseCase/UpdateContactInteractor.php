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

    public function action(Contact $updatedContact): void
    {
        $contactId = $updatedContact->getId();
        (new RemoveContactInteractor($this->commandRepo))->action($contactId);
        (new AddContactInteractor($this->commandRepo))->action(
            $updatedContact->getName(),
            $updatedContact->getNickname(),
            $updatedContact->getPhone()
        );
    }
}
