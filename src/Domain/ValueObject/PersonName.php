<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use DomainException;
use JsonSerializable;

class PersonName implements JsonSerializable
{
    private string $personName;

    public function __construct(string $personName)
    {
        $nameRegex = "/^[\p{L} ]{1,100}$/u";
        if (!preg_match($nameRegex, $personName)) {
            throw new DomainException('InvalidPersonName');
        }

        $this->personName = $personName;
    }

    public function jsonSerialize(): string
    {
        return $this->personName;
    }

    public function __toString()
    {
        return $this->personName;
    }
}
