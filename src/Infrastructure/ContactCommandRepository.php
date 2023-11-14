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
use League\Flysystem\Local\LocalFilesystemAdapter;
use RuntimeException;
use Throwable;

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
        $contactFileName = $updatedContact->getId()->getId() . '.contact';

        try {
            $contactData = json_encode($updatedContact, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new RuntimeException('Contact data is invalid.');
        }

        try {
            $this->filesystem->update($contactFileName, $contactData);
        } catch (FileNotFoundException $e) {
            throw new RuntimeException('Contact does not exist.');
        }
    }
}
