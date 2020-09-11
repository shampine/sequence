<?php
declare(strict_types=1);

namespace Shampine\Sequence\Exceptions;

use Exception;

class SequenceException extends Exception
{
    use ExceptionTrait;

    /**
     * @param int $errorCode
     * @param string $errorMessage
     * @param int $httpCode
     */
    public function __construct(int $errorCode = 0, string $errorMessage = "", int $httpCode = 0)
    {
        parent::__construct($errorMessage, $httpCode);

        $this->setErrorCode($errorCode)
             ->setErrorMessage($errorMessage)
             ->setHttpCode($httpCode);
    }
}
