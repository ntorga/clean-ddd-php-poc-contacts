<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Repository\ContactQueryRepositoryInterface;
use RuntimeException;
use Throwable;

class GetContacts
{
    private ContactQueryRepositoryInterface $queryRepo;

    public function __construct(
        ContactQueryRepositoryInterface $queryRepo
    ) {
        $this->queryRepo = $queryRepo;
    }

    public function action(): array
    {
        try {
            return $this->queryRepo->get();
        } catch (Throwable $th) {
            error_log($th->getMessage());
            throw new RuntimeException('GetContactsInfraError');
        }
    }
}
