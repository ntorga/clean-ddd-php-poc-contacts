<?php


declare(strict_types=1);

namespace Tests\Domain\UseCase;

use App\Domain\Entity\Contact;
use App\Domain\UseCase\GetContactInteractor;
use App\Domain\UseCase\UpdateContactInteractor;
use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use App\Infrastructure\ContactCommandRepository;
use App\Infrastructure\ContactQueryRepository;
use PHPUnit\Framework\TestCase;
use Tests\InteractorTrait;
use Tests\LoadEnvsTrait;

class UpdateContactInteractorTest extends TestCase
{
    use LoadEnvsTrait;
    use InteractorTrait;

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
        $this->addContact();
        $contact = new Contact(
            $contactId,
            new PersonName('Raymond Stantz'),
            new Nickname('Raymond'),
            new PhoneNumber('555-2368')
        );

        $updateContactInteractor = new UpdateContactInteractor($this->commandRepo);
        $updateContactInteractor->action($contact);

        $getContact = new GetContactInteractor($this->queryRepo);
        $sut = $getContact->action($contactId);
        self::assertEquals('Raymond Stantz', $sut->getName());

        $this->removeContact();
    }
}