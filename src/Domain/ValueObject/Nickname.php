<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use JsonSerializable;
use DomainException;

class Nickname implements JsonSerializable
{
    private string $nickname;

    public function __construct(string $nickname)
    {
        $nicknameRegex = "/^[\p{L}]{1,100}$/";
        if (!preg_match($nicknameRegex, $nickname)) {
            throw new DomainException('InvalidNickname');
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
