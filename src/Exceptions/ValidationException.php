<?php
declare(strict_types=1);

namespace Shampine\Sequence\Exceptions;

use Exception;

class ValidationException extends Exception
{
    use ExceptionTrait;

    /**
     * @var array
     */
    protected array $errorMessages = [];

    /**
     * @param int $errorCode
     * @param array $errorMessages
     * @param int $httpCode
     */
    public function __construct(int $errorCode = 0, array $errorMessages = [], int $httpCode = 0)
    {
        parent::__construct('Validation error', $httpCode);

        $this->setErrorCode($errorCode)
             ->setErrorMessages($errorMessages)
             ->setHttpCode($httpCode);
    }

    /**
     * @return array
     */
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    /**
     * @param array $errorMessages
     * @return $this
     */
    public function setErrorMessages(array $errorMessages): self
    {
        $this->errorMessages = $errorMessages;
        return $this;
    }
}
