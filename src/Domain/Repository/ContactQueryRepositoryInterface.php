<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Contact;
use App\Domain\ValueObject\ContactId;

interface ContactQueryRepositoryInterface
{
    public function get(): array;
    public function getById(ContactId $contactId): Contact;
}
