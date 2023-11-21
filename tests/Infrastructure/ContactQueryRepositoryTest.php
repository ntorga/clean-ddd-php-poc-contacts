<?php

declare(strict_types=1);

namespace Tests\Infrastructure;

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
}
