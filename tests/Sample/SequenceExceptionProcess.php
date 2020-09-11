<?php
declare(strict_types=1);

namespace Sample;

use Shampine\Sequence\Exceptions\SequenceException;

class SequenceExceptionProcess
{
    protected bool $fail;

    public function __construct(bool $fail)
    {
        $this->fail = $fail;
    }

    public function process($payload)
    {
        if ($this->fail) {
            throw new SequenceException();
        }

        return $payload;
    }
}
