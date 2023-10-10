<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObject\Backup;

use PHPUnit\Framework\TestCase;
use Tests\ValidInvalidTestTrait;
use App\Domain\ValueObject\PhoneNumber;

class PhoneNumberTest extends TestCase
{
    use ValidInvalidTestTrait;

    const validOptions = [
        "(123) 1234-1234",
        "123 1234-1234",
        "1231234-1234",
        "12312341234"
    ];

    const invalidOptions = [
        "",
        "(123456789) 123456789123456789",
        "111a6ef6bc2314@$%a0",
        "/<script>alert('TEST');</script>",
        "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA"
    ];

    public function testWithValidOptions(): void
    {
        $this->validOptionsTest(self::validOptions, PhoneNumber::class);
    }

    public function testWithInvalidOptions(): void
    {
        $this->invalidOptionsTest(self::invalidOptions, PhoneNumber::class);
    }
}
