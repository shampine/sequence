<?php
declare(strict_types=1);

namespace Shampine\Sequence\Payload;

use Exception;
use Shampine\Sequence\Exceptions\SequenceException;
use Shampine\Sequence\Exceptions\ValidationException;

class ErrorResponsePayload extends AbstractResponsePayload
{
    /**
     * @param Exception|null $exception
     */
    public function __construct(?Exception $exception = null)
    {
        if ($exception instanceof ValidationException) {
            $this->setErrorMessages($exception->getErrorMessages())
                 ->setErrorCode($exception->getErrorCode())
                 ->setStatusCode($exception->getHttpCode());
        } elseif ($exception instanceof SequenceException) {
            $this->setMessage($exception->getMessage())
                 ->setErrorCode($exception->getErrorCode())
                 ->setStatusCode($exception->getHttpCode());
        }
    }
}
