<?php
declare(strict_types=1);

namespace Shampine\Sequence\Process;

abstract class AbstractProcess
{
    public function __invoke()
    {
        if (method_exists($this, 'process')) {
            return $this->process();
        }
    }
}
