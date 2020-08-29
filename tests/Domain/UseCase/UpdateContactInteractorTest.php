<?php


declare(strict_types=1);

namespace Tests\Domain\UseCase;

use App\Domain\Entity\Contact;
use App\Domain\UseCase\AddContactInteractor;
use App\Domain\UseCase\GetContactInteractor;
use App\Domain\UseCase\RemoveContactInteractor;
use App\Domain\UseCase\UpdateContactInteractor;
use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use App\Infrastructure\ContactCommandRepository;
use App\Infrastructure\ContactQueryRepository;
use PHPUnit\Framework\TestCase;
use Tests\LoadEnvsTrait;

class UpdateContactInteractorTest extends TestCase
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

    public function testUpdateContact(): void
    {
        $contactId = new ContactId(1);
        $addContantInteractor = new AddContactInteractor($this->commandRepo);
        $addContantInteractor->action(
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

        $updateContactInteractor = new UpdateContactInteractor($this->commandRepo);
        $updateContactInteractor->action($contact);

        $getContact = new GetContactInteractor($this->queryRepo);
        $sut = $getContact->action($contactId);
        self::assertEquals('John Doe', $sut->getName());

        $removeContactInteractor = new RemoveContactInteractor($this->commandRepo);
        $removeContactInteractor->action($contactId);
    }
}