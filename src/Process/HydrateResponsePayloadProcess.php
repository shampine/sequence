<?php
declare(strict_types=1);

namespace Shampine\Sequence\Process;

use Shampine\Sequence\Payload\AbstractResponsePayload;

class HydrateResponsePayloadProcess extends AbstractProcess
{
    protected string $responsePayload;

    public function __construct(string $responsePayload)
    {
        $this->responsePayload = $responsePayload;
    }

    public function process($payload): AbstractResponsePayload
    {
        return new $this->responsePayload($payload);
    }
}
