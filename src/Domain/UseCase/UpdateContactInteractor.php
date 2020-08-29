<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Entity\Contact;
use App\Domain\Repository\ContactCommandRepositoryInterface;
use RuntimeException;
use Throwable;

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
        try {
            $this->commandRepo->updateContact($updatedContact);
        } catch (Throwable $th) {
            throw new RuntimeException($th->getMessage());
        }
    }
}
