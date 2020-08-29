<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use JsonSerializable;
use RuntimeException;

class Nickname implements JsonSerializable
{
    private string $nickname;

    public function __construct(string $nickname)
    {
        $validLength = strlen($nickname) < 20;
        if (!$validLength) {
            throw new RuntimeException(
                'Nickname cannot be longer than 20 characters.'
            );
        }

        $onlyValidChars = ctype_alnum(
                str_replace(' ', '', $nickname)
            ) === TRUE;
        if (!$onlyValidChars) {
            throw new RuntimeException(
                'Only alphanumeric characters are allowed on Nickname.'
            );
        }

        $this->nickname = $nickname;
    }

    public function jsonSerialize(): string
    {
        return $this->nickname;
    }

    public function __toString()
    {
        return $this->nickname;
    }
}
