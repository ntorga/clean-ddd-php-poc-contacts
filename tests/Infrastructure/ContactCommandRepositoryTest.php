<?php

declare(strict_types=1);

namespace Tests\Infrastructure;

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

    public function testAddAndRemoveContact(): void
    {
        $contactId = new ContactId(1);
        $this->expectNotToPerformAssertions();
        $this->commandRepo->addContact(
            new PersonName('Egon Spengler'),
            new Nickname('Egon'),
            new PhoneNumber('555-2368')
        );
        $this->commandRepo->removeContact($contactId);
    }
}