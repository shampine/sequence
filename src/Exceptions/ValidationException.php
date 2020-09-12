<?php
declare(strict_types=1);

namespace Shampine\Sequence\Exceptions;

use Exception;

class ValidationException extends Exception
{
    use ExceptionTrait;

    /**
     * @param int $errorCode
     * @param array<array<string>|string> $errorMessages
     * @param int $httpCode
     */
    public function __construct(int $errorCode = 0, array $errorMessages = [], int $httpCode = 0)
    {
        parent::__construct('Validation error', $httpCode);

        $this->setErrorCode($errorCode)
             ->setErrorMessages($errorMessages)
             ->setErrorMessage('Validation error')
             ->setHttpCode($httpCode);
    }
}
