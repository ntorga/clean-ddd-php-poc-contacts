<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Entity\Contact;
use App\Domain\Repository\ContactQueryRepositoryInterface;
use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use JsonException;
use League\Flysystem\Adapter\Local;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;
use RuntimeException;

class ContactQueryRepository implements ContactQueryRepositoryInterface
{
    private Filesystem $contactsDir;

    public function __construct()
    {
        $this->contactsDir = new Filesystem(
            new Local($_ENV["CONTACTS_DIR"])
        );
    }

    private function getContactFiles(): array
    {
        $allInodes = $this->contactsDir->listContents();
        $contactFiles = [];
        foreach ($allInodes as $inode) {
            $isFile = $inode["type"] === "file";
            if (!$isFile) {
                continue;
            }

            $isContact = $inode["extension"] === "contact";
            if ($isContact) {
                $contactFiles[] = $inode["path"];
            }
        }
        return $contactFiles;
    }

    private function loadContactFromFile(string $contactFile): Contact
    {
        try {
            $contactFileContent = $this->contactsDir->read($contactFile);
        } catch (FileNotFoundException $e) {
            throw new RuntimeException('File does not exist.');
        }

        try {
            $contactRaw = json_decode($contactFileContent,
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            throw new RuntimeException('Contact data invalid.');
        }

        return new Contact(
            new ContactId((int)$contactRaw["id"]),
            new PersonName($contactRaw["name"]),
            new Nickname($contactRaw["nickname"]),
            new PhoneNumber($contactRaw["phone"])
        );
    }

    public function getContacts(): array
    {
        $contactFiles = $this->getContactFiles();
        $contacts = [];
        foreach ($contactFiles as $contactFile) {
            try {
                $contacts[] = $this->loadContactFromFile($contactFile);
            } catch (RuntimeException $e) {
                continue;
            }
        }
        return $contacts;
    }
}
