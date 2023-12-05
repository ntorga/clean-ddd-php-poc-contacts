<?php

declare(strict_types=1);

namespace Tests\Infrastructure;

use App\Domain\Dto\AddContact;
use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use App\Infrastructure\ContactCommandRepository;
use PHPUnit\Framework\TestCase;
use Tests\LoadEnvsTrait;

class ContactCommandRepositoryTest extends TestCase
{
    use LoadEnvsTrait;

    private ContactCommandRepository $commandRepo;

    public function setUp(): void
    {
        $this->loadEnvs();
        $this->commandRepo = new ContactCommandRepository();
    }

    public function addDummyContact(): void
    {
        $addContactDto = new AddContact(
            new PersonName('Egon Spengler'),
            new Nickname('Egon'),
            new PhoneNumber('555-2368')
        );
        $this->commandRepo->add($addContactDto);
    }

    public function removeDummyContact(): void
    {
        $contactId = new ContactId(1);
        $this->commandRepo->remove($contactId);
    }

    public function testAddAndRemoveContact(): void
    {
        $this->expectNotToPerformAssertions();
        $this->addDummyContact();
        $this->removeDummyContact();
    }
}
