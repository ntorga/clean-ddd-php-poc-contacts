<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObject\Backup;

use PHPUnit\Framework\TestCase;
use Tests\ValidInvalidTestTrait;
use App\Domain\ValueObject\Nickname;

class NicknameTest extends TestCase
{
    use ValidInvalidTestTrait;

    const validOptions = [
        "ntorga",
        "bill_gates",
        "elon-musk"
    ];

    const invalidOptions = [
        "",
        "@ntorga",
        "111a6ef6bc2314@$%a0",
        "/<script>alert('TEST');</script>",
        "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA"
    ];

    public function testWithValidOptions(): void
    {
        $this->validOptionsTest(self::validOptions, Nickname::class);
    }

    public function testWithInvalidOptions(): void
    {
        $this->invalidOptionsTest(self::invalidOptions, Nickname::class);
    }
}
