<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Nickname implements \JsonSerializable
{
    private string $nickname;

    public function __construct(string $nickname)
    {
        $validLength = strlen($nickname) === 15;
        if (!$validLength) {
            throw new \Exception('Nickname cannot be longer than 15 characters.');
        }

        $onlyValidChars = ctype_alnum(str_replace(' ', '', $nickname)) === TRUE;
        if (!$onlyValidChars) {
            throw new \Exception('Nickname provided is not valid.');
        }

        $this->nickname = $nickname;
    }

    public function __toString()
    {
        return $this->nickname;
    }

    public function jsonSerialize(): string
    {
        return $this->nickname;
    }
}
