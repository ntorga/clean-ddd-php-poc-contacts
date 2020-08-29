<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Entity\Contact;
use App\Domain\Repository\ContactCommandRepositoryInterface;
use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use JsonException;
use League\Flysystem\Adapter\Local;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;
use RuntimeException;
use Throwable;

class ContactCommandRepository implements ContactCommandRepositoryInterface
{
    private Filesystem $contactsDir;
    private array $contacts;

    public function __construct()
    {
        $this->contactsDir = new Filesystem(
            new Local($_ENV["CONTACTS_DIR"])
        );
        $this->contacts = (new ContactQueryRepository())->getContacts();
    }

    public function addContact(
        PersonName $name,
        Nickname $nickname,
        PhoneNumber $phoneNumber
    ): void
    {
        try {
            $newContactId = end($this->contacts)["id"] + 1;
        } catch (Throwable $th) {
            $newContactId = 1;
        }

        try {
            $contactData = json_encode(new Contact(
                new ContactId($newContactId),
                $name,
                $nickname,
                $phoneNumber
            ), JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new RuntimeException('Contact data is invalid.');
        }

        $contactFileName = $newContactId . '.contact';
        $this->contactsDir->put($contactFileName, $contactData);
    }

    public function removeContact(ContactId $contactId): void
    {
        $contactFileName = $contactId->getId() . '.contact';
        try {
            $this->contactsDir->delete($contactFileName);
        } catch (FileNotFoundException $e) {
            if ($this->contactsDir->has($contactFileName)) {
                throw new RuntimeException('Unable to delete contact.');
            }
        }
    }
}
