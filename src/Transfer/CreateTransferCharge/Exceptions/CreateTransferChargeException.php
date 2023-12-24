<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk\Transfer\CreateTransferCharge\Exceptions;

use Exception;

final class CreateTransferChargeException extends Exception
{
    private string $description;
    private string $type;
    private array $requestPayload;
    private array $responsePayload;

    public function __construct(
        int $code,
        string $description,
        string $type,
        array $requestPayload,
        array $responsePayload
    ) {
        $this->code = $code;
        $this->type = $type;
        $this->description = $description;
        $this->requestPayload = $requestPayload;
        $this->responsePayload = $responsePayload;
        parent::__construct("$description - [{$code}]");
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getRequestPayload(): array
    {
        return $this->requestPayload;
    }

    public function getResponsePayload(): array
    {
        return $this->responsePayload;
    }
}
