<?php


declare(strict_types=1);

namespace Tests\Domain\UseCase;

use App\Domain\UseCase\GetContactInteractor;
use App\Domain\ValueObject\ContactId;
use App\Infrastructure\ContactQueryRepository;
use PHPUnit\Framework\TestCase;
use Tests\InteractorTrait;
use Tests\LoadEnvsTrait;

class GetContactInteractorTest extends TestCase
{
    use LoadEnvsTrait;
    use InteractorTrait;

    public function setUp(): void
    {
        $this->loadEnvs();
    }

    public function testGetContactWithName(): void
    {
        $queryRepo = new ContactQueryRepository();
        $contactId = new ContactId(1);

        $this->addContact();

        $getContact = new GetContactInteractor($queryRepo);
        $sut = $getContact->action($contactId);
        self::assertEquals('Jane Doe', $sut->getName());

        $this->removeContact();
    }
}