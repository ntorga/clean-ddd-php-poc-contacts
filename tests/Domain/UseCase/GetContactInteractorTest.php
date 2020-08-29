<?php


declare(strict_types=1);

namespace Tests\Domain\UseCase;

use App\Domain\UseCase\GetContactInteractor;
use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use App\Infrastructure\ContactCommandRepository;
use App\Infrastructure\ContactQueryRepository;
use PHPUnit\Framework\TestCase;
use Tests\LoadEnvsTrait;

class GetContactInteractorTest extends TestCase
{
    use LoadEnvsTrait;

    public function setUp(): void
    {
        $this->loadEnvs();
    }

    public function testGetContactWithName(): void
    {
        $queryRepo = new ContactQueryRepository();
        $commandRepo = new ContactCommandRepository();
        $contactId = new ContactId(1);
        $commandRepo->addContact(
            new PersonName('John Doe'),
            new Nickname('John'),
            new PhoneNumber('555-2368')
        );
        $getContact = new GetContactInteractor($queryRepo);
        $sut = $getContact->action($contactId);
        self::assertEquals('John Doe', $sut->getName());
        $commandRepo->removeContact($contactId);
    }
}