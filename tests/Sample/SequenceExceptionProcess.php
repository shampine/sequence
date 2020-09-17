<?php
declare(strict_types=1);

namespace Sample;

use Shampine\Sequence\Exceptions\SequenceException;
use Shampine\Sequence\Process\AbstractProcess;
use Shampine\Sequence\Support\StatusCode;

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
     * @param SamplePayload $payload
     * @return SamplePayload
     * @throws SequenceException
     */
    public function process($payload): SamplePayload
    {
        if ($this->fail) {
            throw new SequenceException(
                6666,
                'Something went horribly wrong',
                StatusCode::INTERNAL_SERVER_ERROR
            );
        }

        return $payload;
    }
}
