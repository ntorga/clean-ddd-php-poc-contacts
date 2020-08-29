<?php

declare(strict_types=1);

namespace Tests;

use Dotenv\Dotenv;

trait LoadEnvsTrait
{
    public function loadEnvs(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../config/");
        $dotenv->load();
    }
}
