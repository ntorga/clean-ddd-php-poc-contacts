<?php

declare(strict_types=1);

namespace App\Domain\Dto;

use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;

/**
 * @OA\Schema(
 *   title="UpdateContact",
 *   required={"id"}
 * )
 */
class UpdateContact
{
    public function __construct(
        /**
         * @OA\Property(type="integer", format="int32")
         */
        public readonly ContactId $id,

        /**
         * @OA\Property(type="string")
         */
        public readonly ?PersonName $name,

        /**
         * @OA\Property(type="string")
         */
        public readonly ?Nickname $nickname,

        /**
         * @OA\Property(type="string")
         */
        public readonly ?PhoneNumber $phone,
    ) {}
}
