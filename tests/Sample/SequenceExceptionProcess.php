<?php
declare(strict_types=1);

namespace Sample;

use Shampine\Sequence\Exceptions\SequenceException;
use Shampine\Sequence\Process\AbstractProcess;

class SequenceExceptionProcess extends AbstractProcess
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
     * @throws SequenceException
     */
    public function process($payload): SampleRequestPayload
    {
        if ($this->fail) {
            throw new SequenceException();
        }

        return $payload;
    }
}
