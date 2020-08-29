<?php


declare(strict_types=1);

namespace Tests\Domain\UseCase;

use App\Domain\UseCase\GetContactInteractor;
use App\Domain\ValueObject\ContactId;
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
        $getContact = new GetContactInteractor($queryRepo);
        $sut = $getContact->action(new ContactId(1));
        self::assertEquals('John Doe', $sut->getName());
    }
}