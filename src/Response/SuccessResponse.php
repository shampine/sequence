<?php
declare(strict_types=1);

namespace Shampine\Sequence\Response;

use Shampine\Sequence\Support\StatusCode;

class SuccessResponse
{
    /**
     * @var int|null $errorCode
     */
    protected ?int $errorCode = null;

    /**
     * @var int
     */
    protected int $statusCode = StatusCode::OK;

    /**
     * @var array<mixed>|null
     */
    protected ?array $data = null;

    /**
     * @var string|null
     */
    protected ?string $message = null;

    /**
     * @var array<array<string>|string>|null
     */
    protected ?array $errorMessages = null;

    /**
     * @return int|null
     */
    public function getErrorCode(): ?int
    {
        return $this->errorCode;
    }

    /**
     * @param int|null $errorCode
     * @return $this
     */
    public function setErrorCode(?int $errorCode): self
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return array<mixed>|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @param array<mixed>|null $data
     * @return $this
     */
    public function setData(?array $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return $this
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return array<array<string>|string>|null
     */
    public function getErrorMessages(): ?array
    {
        return $this->errorMessages;
    }

    /**
     * @param array<array<string>|string>|null $errorMessages
     * @return $this
     */
    public function setErrorMessages(?array $errorMessages): self
    {
        $this->errorMessages = $errorMessages;
        return $this;
    }
}
