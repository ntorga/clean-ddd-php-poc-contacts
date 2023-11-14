<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Dto\AddContact;
use App\Domain\Dto\UpdateContact;
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

    public function add(AddContact $addContact): void
    {
        $newContactId = count($this->contacts) + 1;

        $contactEntity = new Contact(
            new ContactId($newContactId),
            $addContact->getName(),
            $addContact->getNickname(),
            $addContact->getPhone()
        );

        try {
            $contactData = json_encode(
                $contactEntity,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            throw new RuntimeException('ContactDataInvalid');
        }

        $contactFileName = $newContactId . '.contact';
        $this->contactsDir->put($contactFileName, $contactData);
    }

    public function remove(ContactId $contactId): void
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

    public function update(UpdateContact $updatedContact): void
    {
        $contactFileName = $updatedContact->getId()->getId() . '.contact';

        try {
            $contactData = json_encode($updatedContact, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new RuntimeException('Contact data is invalid.');
        }

        try {
            $this->contactsDir->update($contactFileName, $contactData);
        } catch (FileNotFoundException $e) {
            throw new RuntimeException('Contact does not exist.');
        }
    }
}
