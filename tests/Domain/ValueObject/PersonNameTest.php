<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObject\Backup;

use PHPUnit\Framework\TestCase;
use Tests\ValidInvalidTestTrait;
use App\Domain\ValueObject\PersonName;

class PersonNameTest extends TestCase
{
    use ValidInvalidTestTrait;

    const validOptions = [
        "João da Silva",
        "Maria da Silva",
        "José da Silva"
    ];

    const invalidOptions = [
        "",
        "111a6ef6bc2314@$%a0",
        "/<script>alert('TEST');</script>",
        "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA"
    ];

    public function testWithValidOptions(): void
    {
        $this->validOptionsTest(self::validOptions, PersonName::class);
    }

    public function testWithInvalidOptions(): void
    {
        $this->invalidOptionsTest(self::invalidOptions, PersonName::class);
    }
}
