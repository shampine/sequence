<?php
declare(strict_types=1);

namespace Shampine\Sequence\Process;

use RuntimeException;
use Shampine\Sequence\Payload\AbstractRequestPayload;
use Shampine\Sequence\Payload\AbstractResponsePayload;

abstract class AbstractProcess
{
    /**
     * @param AbstractRequestPayload $payload
     * @return AbstractRequestPayload|AbstractResponsePayload
     */
    public function __invoke($payload)
    {
        if (!method_exists($this, 'process')) {
            throw new RuntimeException('Process method undefined');
        }

        return $this->process($payload);
    }

    /**
     * @param AbstractRequestPayload $payload
     * @return AbstractRequestPayload|AbstractResponsePayload
     */
    abstract public function process($payload);
}
