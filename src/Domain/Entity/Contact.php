<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PhoneNumber;

class Contact implements \JsonSerializable
{
    private array $contact;

    public function __construct(
        ContactId $id,
        PersonName $name,
        Nickname $nickname,
        PhoneNumber $phone
    ) {
        $this->contact = [
            "id" => $id,
            "name" => $name,
            "nickname" => $nickname,
            "phone" => $phone
        ];
    }

    public function getId(): ContactId
    {
        return $this->contact["id"];
    }

    public function getName(): PersonName
    {
        return $this->contact["name"];
    }

    public function getNick(): Nickname
    {
        return $this->contact["nick"];
    }

    public function getPhone(): PhoneNumber
    {
        return $this->contact["phone"];
    }

    public function jsonSerialize(): array
    {
        return $this->contact;
    }
}
