<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use JsonSerializable;

class Contact implements JsonSerializable
{
    private ContactId $id;
    private PersonName $name;
    private Nickname $nickname;
    private PhoneNumber $phone;

    public function __construct(
        ContactId $id,
        PersonName $name,
        Nickname $nickname,
        PhoneNumber $phone
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->nickname = $nickname;
        $this->phone = $phone;
    }

    public function getId(): ContactId
    {
        return $this->id;
    }

    public function getName(): PersonName
    {
        return $this->name;
    }

    public function getNickname(): Nickname
    {
        return $this->nickname;
    }

    public function getPhone(): PhoneNumber
    {
        return $this->phone;
    }

    public function jsonSerialize(): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "nickname" => $this->nickname,
            "phone" => $this->phone
        ];
    }
}
