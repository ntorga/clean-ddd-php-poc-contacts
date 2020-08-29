<?php

declare(strict_types=1);

namespace Tests;

use App\Domain\UseCase\AddContactInteractor;
use App\Domain\UseCase\RemoveContactInteractor;
use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use App\Infrastructure\ContactCommandRepository;

trait InteractorTrait
{
    public function addContact(): void
    {
        $commandRepo = new ContactCommandRepository();
        $addContact = new AddContactInteractor($commandRepo);
        $addContact->action(
            new PersonName('Egon Spengler'),
            new Nickname('Egon'),
            new PhoneNumber('555-2368')
        );
    }

    public function removeContact(): void
    {
        $commandRepo = new ContactCommandRepository();
        $removeContact = new RemoveContactInteractor($commandRepo);
        $removeContact->action(new ContactId(1));
    }
}
