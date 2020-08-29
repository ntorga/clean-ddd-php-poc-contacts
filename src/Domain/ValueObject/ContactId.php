<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use JsonSerializable;
use RuntimeException;

class ContactId implements JsonSerializable
{
    private int $contactId;

    public function __construct(int $contactId)
    {
        $isOutOfRange = filter_var(
                $contactId,
                FILTER_VALIDATE_INT,
                array('options' => array('min_range' => 1, 'max_range' => 50000))
            ) === FALSE;

        if ($isOutOfRange) {
            throw new RuntimeException('Contact ID out of range.');
        }

        $this->contactId = $contactId;
    }

    public function getId(): int
    {
        return $this->contactId;
    }

    public function jsonSerialize(): int
    {
        return $this->contactId;
    }

    public function __toString()
    {
        return (string)$this->contactId;
    }
}
