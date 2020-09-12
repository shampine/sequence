<?php
declare(strict_types=1);

namespace Shampine\Sequence\Response;

use Exception;
use Shampine\Sequence\Exceptions\SequenceException;
use Shampine\Sequence\Exceptions\ValidationException;

class ErrorResponse extends SuccessResponse
{
    /**
     * @param Exception|null $exception
     */
    public function __construct(?Exception $exception = null)
    {
        if ($exception instanceof ValidationException) {
            $this->setErrorMessages($exception->getErrorMessages())
                 ->setMessage($exception->getErrorMessage())
                 ->setErrorCode($exception->getErrorCode())
                 ->setStatusCode($exception->getHttpCode());
        } elseif ($exception instanceof SequenceException) {
            $this->setMessage($exception->getMessage())
                 ->setErrorCode($exception->getErrorCode())
                 ->setStatusCode($exception->getHttpCode());
        }
    }
}
