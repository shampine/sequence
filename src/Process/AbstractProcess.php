<?php
declare(strict_types=1);

namespace Shampine\Sequence\Process;

use RuntimeException;

abstract class AbstractProcess
{
    /**
     * @param mixed $payload
     * @return mixed
     * @throws RuntimeException
     */
    public function __invoke($payload)
    {
        if (method_exists($this, 'process')) {
            return $this->process($payload);
        }

        throw new RuntimeException('All processes must define a process() method.');
    }
}
