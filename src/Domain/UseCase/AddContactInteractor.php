<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Repository\ContactCommandRepositoryInterface;
use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;

class AddContactInteractor
{
    private ContactCommandRepositoryInterface $contactRepository;

    public function __construct(
        ContactCommandRepositoryInterface $contactRepository
    ) {
        $this->contactRepository = $contactRepository;
    }

    public function action(
        PersonName $name,
        Nickname $nick,
        PhoneNumber $phone
    ): ContactId {
        try {
            $contact = $this->contactRepository->addContact(
                $name,
                $nick,
                $phone
            );
        } catch (\Throwable $e) {
            throw new \Exception('Unable to create contact.');
        }
        return $contact->getId();
    }
}
