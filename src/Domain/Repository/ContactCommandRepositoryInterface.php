<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Dto\AddContact;
use App\Domain\Dto\UpdateContact;
use App\Domain\ValueObject\ContactId;

interface ContactCommandRepositoryInterface
{
    public function add(AddContact $addContact): void;
    public function remove(ContactId $contactId): void;
    public function update(UpdateContact $updatedContact): void;
}
