<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use JsonSerializable;
use RuntimeException;

class PhoneNumber implements JsonSerializable
{
    private string $phoneNumber;

    public function __construct(string $phoneNumber)
    {
        $validLength = strlen($phoneNumber) < 30;
        if (!$validLength) {
            throw new RuntimeException(
                'Phone numbers must have a maximum of 30 numbers.'
            );
        }

        $expectedFormat = "/^(\(\d{3}\)\s|\d{3}-)?\d{3}-\d{4}$/";
        if (!preg_match($expectedFormat, $phoneNumber)) {
            throw new RuntimeException(
                'Phone number provided must follow US format.'
            );
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
