<?php

declare(strict_types=1);

namespace App\Presentation\Api\Helper;

use BadMethodCallException;
use Psr\Http\Message\ServerRequestInterface as Request;

class MissingParamHelper
{
    public static function action(Request $request, array $requiredParams): void
    {
        $requestBody = $request->getParsedBody();

        if (!is_array($requestBody)) {
            throw new BadMethodCallException('InvalidRequestBody');
        }

        $missingParams = array_diff($requiredParams, array_keys($requestBody));
        if (count($missingParams) > 0) {
            throw new BadMethodCallException(
                "MissingRequiredParams: " . implode(',', $missingParams)
            );
        }
    }
}
