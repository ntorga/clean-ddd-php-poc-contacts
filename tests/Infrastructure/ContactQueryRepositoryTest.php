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
        $sut = $this->queryRepo->get();
        $hasItems = count($sut) > 0;
        $this->assertTrue($hasItems);
    }

    public function testGetContactById(): void
    {
        $contactId = new ContactId(1);
        $sut = $this->queryRepo->getById($contactId);
        $this->expectNotToPerformAssertions();
    }

    public function testGetCount(): void
    {
        $sut = $this->queryRepo->count();
        $this->assertTrue($sut > 0);
    }
}
