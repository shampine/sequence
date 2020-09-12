<?php
declare(strict_types=1);

namespace Shampine\Sequence\Process;

abstract class AbstractProcess
{
    /**
     * @param mixed $payload
     * @return mixed
     */
    public function __invoke($payload)
    {
        return $this->process($payload);
    }

    /**
     * @param mixed $payload
     * @return mixed
     */
    abstract public function process($payload);
}
