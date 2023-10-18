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
    /**
     * @OA\Property(type="integer", format="int32")
     */
    private ContactId $id;

    /**
     * @OA\Property(type="string")
     */
    private ?PersonName $name;

    /**
     * @OA\Property(type="string")
     */
    private ?Nickname $nickname;

    /**
     * @OA\Property(type="string")
     */
    private ?PhoneNumber $phone;

    public function __construct(
        ContactId $id,
        ?PersonName $name = null,
        ?Nickname $nickname = null,
        ?PhoneNumber $phone = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->nickname = $nickname;
        $this->phone = $phone;
    }
}
