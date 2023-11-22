<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Entity\Contact;
use App\Domain\Repository\ContactQueryRepositoryInterface;
use App\Domain\ValueObject\ContactId;
use App\Domain\ValueObject\Nickname;
use App\Domain\ValueObject\PersonName;
use App\Domain\ValueObject\PhoneNumber;
use League\Flysystem\FileAttributes;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use JsonException;
use RuntimeException;

class ContactQueryRepository implements ContactQueryRepositoryInterface
{
    private Filesystem $filesystem;

    public function __construct()
    {
        $rootPath = $_ENV["CONTACTS_DIR"];
        $adapter = new LocalFilesystemAdapter($rootPath);
        $this->filesystem = new Filesystem($adapter);
    }

    private function getContactFilePaths(): array
    {
        $inodes = $this->filesystem->listContents("", false);
        $contactFiles = [];
        foreach ($inodes as $inode) {
            $isFile = $inode instanceof FileAttributes;
            if (!$isFile) {
                continue;
            }

            $extension = pathinfo($inode->path(), PATHINFO_EXTENSION);
            $isContact = $extension === "contact";
            if ($isContact) {
                $contactFiles[] = $inode["path"];
            }
        }
        return $contactFiles;
    }

    private function contactFactory(string $contactFilePath): Contact
    {
        $contactFileContent = $this->filesystem->read($contactFilePath);

        try {
            $contactRaw = json_decode(
                $contactFileContent,
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            throw new RuntimeException('ContactDataInvalid');
        }

        return new Contact(
            new ContactId($contactRaw["id"]),
            new PersonName($contactRaw["name"]),
            new Nickname($contactRaw["nickname"]),
            new PhoneNumber($contactRaw["phone"])
        );
    }

    public function get(): array
    {
        $contactFilePaths = $this->getContactFilePaths();
        $contacts = [];
        foreach ($contactFilePaths as $contactFilePath) {
            try {
                $contacts[] = $this->contactFactory($contactFilePath);
            } catch (RuntimeException $e) {
                error_log(
                    "[" . $contactFilePath . "] ContactFactoryError: " . $e->getMessage(),
                );
                continue;
            }
        }
        return $contacts;
    }

    public function getById(ContactId $id): Contact
    {
        $fileName = $id . ".contact";

        $fileExists = $this->filesystem->fileExists($fileName);
        if (!$fileExists) {
            throw new RuntimeException('ContactNotFound');
        }

        return $this->contactFactory($fileName);
    }
}
