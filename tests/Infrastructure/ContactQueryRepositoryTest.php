<?php

declare(strict_types=1);

namespace Tests\Infrastructure;

use App\Domain\ValueObject\ContactId;
use App\Infrastructure\ContactQueryRepository;
use PHPUnit\Framework\TestCase;
use Tests\LoadEnvsTrait;

class ContactQueryRepositoryTest extends TestCase
{
    use LoadEnvsTrait;

    private ContactQueryRepository $queryRepo;

    public function setUp(): void
    {
        $this->loadEnvs();
        $this->queryRepo = new ContactQueryRepository();
    }

    public function testGetContacts(): void
    {
        ContactCommandRepositoryTest::addDummyContact();

        $sut = $this->queryRepo->get();
        $hasItems = count($sut) > 0;
        $this->assertTrue($hasItems);

        ContactCommandRepositoryTest::removeDummyContact();
    }

    public function testGetContactById(): void
    {
        ContactCommandRepositoryTest::addDummyContact();

        $contactId = new ContactId(1);
        $this->expectNotToPerformAssertions();
        $this->queryRepo->getById($contactId);

        ContactCommandRepositoryTest::removeDummyContact();
    }

    public function testGetCount(): void
    {
        ContactCommandRepositoryTest::addDummyContact();

        $sut = $this->queryRepo->count();
        $this->assertTrue($sut > 0);

        ContactCommandRepositoryTest::removeDummyContact();
    }
}
