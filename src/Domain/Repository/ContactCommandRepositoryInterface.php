<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Contact;
use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;

interface ContactCommandRepositoryInterface
{
    public function addContact(
        PersonName $name,
        Nickname $nickname,
        PhoneNumber $phoneNumber
    ): Contact;
    public function updateContact(Contact $updatedContact): void;
    public function removeContact(ContactId $contactId): void;
}
