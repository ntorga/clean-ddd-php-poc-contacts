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
    }

    public static function addDummyContact(): void
    {
        $commandRepo = new ContactCommandRepository();
        $addContactDto = new AddContact(
            new PersonName('Egon Spengler'),
            new Nickname('Egon'),
            new PhoneNumber('555-2368')
        );
        $commandRepo->add($addContactDto);
    }

    public static function removeDummyContact(): void
    {
        $commandRepo = new ContactCommandRepository();
        $contactId = new ContactId(1);
        $commandRepo->remove($contactId);
    }

    public function testAddAndRemoveContact(): void
    {
        $this->expectNotToPerformAssertions();
        self::addDummyContact();
        self::removeDummyContact();
    }
}
