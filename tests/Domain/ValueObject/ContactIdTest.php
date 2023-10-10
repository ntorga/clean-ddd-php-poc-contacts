<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObject\Backup;

use PHPUnit\Framework\TestCase;
use Tests\ValidInvalidTestTrait;
use App\Domain\ValueObject\ContactId;

class ContactIdTest extends TestCase
{
    use ValidInvalidTestTrait;

    const validOptions = [
        1,
        2,
        3,
        50000
    ];

    const invalidOptions = [
        0,
        50001,
        500000
    ];

    public function testWithValidOptions(): void
    {
        $this->validOptionsTest(self::validOptions, ContactId::class);
    }

    public function testWithInvalidOptions(): void
    {
        $this->invalidOptionsTest(self::invalidOptions, ContactId::class);
    }
}
