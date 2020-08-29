<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Entity\Contact;
use App\Domain\Repository\ContactQueryRepositoryInterface;
use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use Throwable;

class GetContactsInteractor
{
    private ContactQueryRepositoryInterface $queryRepo;

    public function __construct(
        ContactQueryRepositoryInterface $queryRepo
    )
    {
        $this->queryRepo = $queryRepo;
    }

    public function action(): array
    {
        $contactsRaw = $this->queryRepo->getContacts();
        $contacts = [];
        foreach ($contactsRaw as $contact) {
            try {
                $contacts[] = new Contact(
                    new ContactId((int)$contact["id"]),
                    new PersonName($contact["name"]),
                    new Nickname($contact["nickname"]),
                    new PhoneNumber($contact["phone"])
                );
            } catch (Throwable $th) {
                continue;
            }
        }
        return $contacts;
    }
}