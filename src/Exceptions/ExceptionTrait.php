<?php
declare(strict_types=1);

namespace Shampine\Sequence\Exceptions;

trait ExceptionTrait
{
    /**
     * @var int
     */
    protected int $errorCode = 0;

    /**
     * @var int
     */
    protected int $httpCode = 0;

    /**
     * @var string
     */
    protected string $errorMessage = '';

    /**
     * @var array<array<string>|string>
     */
    protected array $errorMessages = [];

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    /**
     * @param int $errorCode
     * @return $this
     */
    public function setErrorCode(int $errorCode)
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @param int $httpCode
     * @return $this
     */
    public function setHttpCode(int $httpCode)
    {
        $this->httpCode = $httpCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * @param string $errorMessage
     * @return $this
     */
    public function setErrorMessage(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    /**
     * @return array<array<string>|string>
     */
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    /**
     * @param array<array<string>|string> $errorMessages
     * @return $this
     */
    public function setErrorMessages(array $errorMessages): self
    {
        $this->errorMessages = $errorMessages;
        return $this;
    }
}
