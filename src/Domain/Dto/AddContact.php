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
    public function __construct(
        /**
         * @OA\Property(type="string")
         */
        public readonly PersonName $name,

        /**
         * @OA\Property(type="string")
         */
        public readonly Nickname $nickname,

        /**
         * @OA\Property(type="string")
         */
        public readonly PhoneNumber $phone
    ) {}

    public function jsonSerialize(): array
    {
        return [
            "name" => $this->name,
            "nickname" => $this->nickname,
            "phone" => $this->phone
        ];
    }
}
