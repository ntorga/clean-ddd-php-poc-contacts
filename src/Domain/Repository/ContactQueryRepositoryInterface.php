<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Contact;
use App\Domain\ValueObject\ContactId;

interface ContactQueryRepositoryInterface
{
    public function getContacts(): array;
    public function getContact(ContactId $contactId): Contact;
}
