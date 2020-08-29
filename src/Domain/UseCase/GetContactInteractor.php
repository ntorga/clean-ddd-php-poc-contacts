<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Entity\Contact;
use App\Domain\Repository\ContactQueryRepositoryInterface;
use App\Domain\ValueObject\ContactId;
use RuntimeException;

class GetContactInteractor
{
    private ContactQueryRepositoryInterface $queryRepo;

    public function __construct(
        ContactQueryRepositoryInterface $queryRepo
    )
    {
        $this->queryRepo = $queryRepo;
    }

    public function action(ContactId $contactId): Contact
    {
        $getContacts = new GetContactsInteractor($this->queryRepo);
        $contacts = $getContacts->action();
        foreach ($contacts as $contact) {
            $isContact = $contact->getId()->getId() === $contactId->getId();
            if ($isContact) {
                return $contact;
            }
        }
        throw new RuntimeException('Contact not found.');
    }
}