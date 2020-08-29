<?php

declare(strict_types=1);

namespace Tests\Domain\UseCase;

use App\Domain\UseCase\GetContactsInteractor;
use App\Infrastructure\ContactQueryRepository;
use PHPUnit\Framework\TestCase;
use Tests\LoadEnvsTrait;

class GetContactsInteractorTest extends TestCase
{
    use LoadEnvsTrait;

    public function setUp(): void
    {
        $this->loadEnvs();
    }

    public function testGetContacts(): void
    {
        $queryRepo = new ContactQueryRepository();
        $getContacts = new GetContactsInteractor($queryRepo);
        $sut = $getContacts->action();
        self::assertIsArray($sut);
    }
}