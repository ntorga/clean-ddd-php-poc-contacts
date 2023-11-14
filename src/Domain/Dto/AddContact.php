<?php

declare(strict_types=1);

namespace App\Domain\Dto;

use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use JsonSerializable;

/**
 * @OA\Schema(
 *   title="AddContact",
 *   required={"name", "nickname", "phone"}
 * )
 */
class AddContact implements JsonSerializable
{
    /**
     * @OA\Property(type="string")
     */
    private PersonName $name;

    /**
     * @OA\Property(type="string")
     */
    private Nickname $nickname;

    /**
     * @OA\Property(type="string")
     */
    private PhoneNumber $phone;

    public function __construct(
        PersonName $name,
        Nickname $nickname,
        PhoneNumber $phone
    ) {
        $this->name = $name;
        $this->nickname = $nickname;
        $this->phone = $phone;
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
            "name" => $this->name,
            "nickname" => $this->nickname,
            "phone" => $this->phone
        ];
    }
}
