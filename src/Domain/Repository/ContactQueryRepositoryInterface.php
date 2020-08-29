<?php

declare(strict_types=1);

namespace App\Domain\Repository;

interface ContactQueryRepositoryInterface
{
    public function getContacts(): array;
}
