<?php

declare(strict_types=1);

namespace Tests\Infrastructure;

use App\Domain\ValueObject\ContactId;
use App\Infrastructure\ContactQueryRepository;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class ContactQueryRepositoryTest extends TestCase
{
    private ContactQueryRepository $queryRepo;

    public function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../../config/");
        $dotenv->load();
        $this->queryRepo = new ContactQueryRepository();
    }

    public function testGetContacts(): void
    {
        $sut = $this->queryRepo->getContacts();
        self::assertIsArray($sut);
    }

    public function testGetContact(): void
    {
        $sut = $this->queryRepo->getContact(new ContactId(1));
        self::assertEquals('John Doe', (string)$sut->getName());
    }
}