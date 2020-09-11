<?php
declare(strict_types=1);

namespace Sample;

use Shampine\Sequence\Exceptions\ValidationException;
use Shampine\Sequence\Process\AbstractProcess;

class ValidationExceptionProcess extends AbstractProcess
{
    protected bool $fail = false;

    public function __construct(bool $fail)
    {
        $this->fail = $fail;
    }

    public function process($payload)
    {
        if ($this->fail) {
            throw new ValidationException();
        }

        return $payload;
    }
}
