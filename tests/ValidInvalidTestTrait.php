<?php

declare(strict_types=1);

namespace Tests;

use Throwable;

trait ValidInvalidTestTrait
{
    public function validOptionsTest(array $options, string $subject): void
    {
        $wronglyDetected = [];
        foreach ($options as $validOption) {
            try {
                new $subject($validOption);
            } catch (Throwable $th) {
                $wronglyDetected[] = $validOption;
                continue;
            }
        }

        !empty($wronglyDetected) ? print_r($wronglyDetected) : '';
        $this->assertEmpty($wronglyDetected);
    }

    public function invalidOptionsTest(array $options, string $subject): void
    {
        $notDetected = [];
        foreach ($options as $invalidOption) {
            try {
                new $subject($invalidOption);
                $notDetected[] = $invalidOption;
            } catch (Throwable $th) {
                continue;
            }
        }

        !empty($notDetected) ? print_r($notDetected) : '';
        $this->assertEmpty($notDetected);
    }
}
