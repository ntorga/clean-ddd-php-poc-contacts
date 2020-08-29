<?php

declare(strict_types=1);

namespace Tests\Infrastructure;

use App\Domain\Entity\Contact;
use App\Domain\UseCase\GetContactInteractor;
use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use App\Infrastructure\ContactCommandRepository;
use App\Infrastructure\ContactQueryRepository;
use PHPUnit\Framework\TestCase;
use Tests\LoadEnvsTrait;

class ContactCommandRepositoryTest extends TestCase
{
    use LoadEnvsTrait;

    private ContactCommandRepository $commandRepo;
    private ContactQueryRepository $queryRepo;

    public function setUp(): void
    {
        $this->loadEnvs();
        $this->commandRepo = new ContactCommandRepository();
        $this->queryRepo = new ContactQueryRepository();
    }

    public function testAddAndRemoveContact(): void
    {
        $contactId = new ContactId(1);
        $this->expectNotToPerformAssertions();
        $this->commandRepo->addContact(
            new PersonName('Jane Doe'),
            new Nickname('Jane'),
            new PhoneNumber('555-2368')
        );
        
        $this->commandRepo->removeContact($contactId);
    }

    public function testUpdateContact(): void
    {
        $contactId = new ContactId(1);
        $this->commandRepo->addContact(
            new PersonName('Jane Doe'),
            new Nickname('Jane'),
            new PhoneNumber('555-2368')
        );
        $contact = new Contact(
            $contactId,
            new PersonName('John Doe'),
            new Nickname('John'),
            new PhoneNumber('555-2368')
        );

        $this->commandRepo->updateContact($contact);

        $getContact = new GetContactInteractor($this->queryRepo);
        $sut = $getContact->action($contactId);
        self::assertEquals('John Doe', $sut->getName());

        $this->commandRepo->removeContact($contactId);
    }
}