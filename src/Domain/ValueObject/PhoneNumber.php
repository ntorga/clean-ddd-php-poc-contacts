<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use DomainException;
use JsonSerializable;

class PhoneNumber implements JsonSerializable
{
    private string $phoneNumber;

    public function __construct(string $phoneNumber)
    {
        // Valid formats: (123) 1234-1234 | 123 1234-1234 | 1231234-1234 | 12312341234
        $expectedFormat = "/^\(?\d{1,3}\)? ?\d{1,5}-?\d{1,5}$/";
        if (!preg_match($expectedFormat, $phoneNumber)) {
            throw new DomainException('InvalidPhoneNumber');
        }

        $this->phoneNumber = $phoneNumber;
    }

    public function jsonSerialize(): string
    {
        return $this->phoneNumber;
    }

    public function __toString()
    {
        return $this->phoneNumber;
    }
}
