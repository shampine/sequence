<?php
declare(strict_types=1);

namespace Shampine\Sequence\Process;

use RuntimeException;

abstract class AbstractProcess
{
    public function __invoke($payload)
    {
        if (!method_exists($this, 'process')) {
            throw new RuntimeException('Process method undefined');
        }

        return $this->process($payload);
    }

    abstract public function process($payload);
}
