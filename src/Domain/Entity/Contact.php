<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use JsonSerializable;

/**
 * @OA\Schema(
 *   title="Contact",
 *   required={"id", "name", "nickname", "phone"}
 * )
 */
class Contact implements JsonSerializable
{
    public function __construct(
        /**
         * @OA\Property(type="integer", format="int32")
         */
        public readonly ContactId $id,

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
    )
    {}

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
