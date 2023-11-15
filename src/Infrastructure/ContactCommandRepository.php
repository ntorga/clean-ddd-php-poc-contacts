<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Dto\AddContact;
use App\Domain\Dto\UpdateContact;
use App\Domain\Entity\Contact;
use App\Domain\Repository\ContactCommandRepositoryInterface;
use App\Domain\ValueObject\ContactId;
use JsonException;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use RuntimeException;

class ContactCommandRepository implements ContactCommandRepositoryInterface
{
    private Filesystem $filesystem;

    public function __construct()
    {
        $rootPath = $_ENV["CONTACTS_DIR"];
        $adapter = new LocalFilesystemAdapter($rootPath);
        $this->filesystem = new Filesystem($adapter);
    }

    public function add(AddContact $addContact): void
    {
        $contactQueryRepo = new ContactQueryRepository();
        $contactsCount = $contactQueryRepo->count();
        $newContactId = $contactsCount + 1;

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
        $this->filesystem->write($contactFileName, $contactData);
    }

    public function remove(ContactId $contactId): void
    {
        $contactFileName = $contactId->getId() . '.contact';
        $this->filesystem->delete($contactFileName);
    }

    public function update(UpdateContact $updatedContact): void
    {
        $contactQueryRepo = new ContactQueryRepository();
        $contact = $contactQueryRepo->getById($updatedContact->getId());

        $personName = $contact->getName();
        if ($updatedContact->getName() !== null) {
            $personName = $updatedContact->getName();
        }

        $nickname = $contact->getNickname();
        if ($updatedContact->getNickname() !== null) {
            $nickname = $updatedContact->getNickname();
        }

        $phoneNumber = $contact->getPhone();
        if ($updatedContact->getPhone() !== null) {
            $phoneNumber = $updatedContact->getPhone();
        }

        $newContact = new Contact(
            $updatedContact->getId(),
            $personName,
            $nickname,
            $phoneNumber
        );

        try {
            $contactData = json_encode(
                $newContact,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            throw new RuntimeException('ContactDataInvalid');
        }

        $contactFileName = $updatedContact->getId() . '.contact';
        $this->filesystem->write($contactFileName, $contactData);
    }
}
