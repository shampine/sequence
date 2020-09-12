<?php
declare(strict_types=1);

namespace Sample;

use Shampine\Sequence\Exceptions\ValidationException;
use Shampine\Sequence\Process\AbstractProcess;

class ValidationExceptionProcess extends AbstractProcess
{
    /**
     * @var bool
     */
    protected bool $fail = false;

    /**
     * @param bool $fail
     */
    public function __construct(bool $fail = false)
    {
        $this->fail = $fail;
    }

    /**
     * @param SampleRequestPayload $payload
     * @return SampleRequestPayload
     * @throws ValidationException
     */
    public function process($payload): SampleRequestPayload
    {
        if ($this->fail) {
            throw new ValidationException();
        }

        return $payload;
    }
}
