<?php
declare(strict_types=1);

namespace Shampine\Sequence\Process;

use Shampine\Sequence\Payload\AbstractRequestPayload;
use Shampine\Sequence\Payload\AbstractResponsePayload;

class HydrateResponsePayloadProcess extends AbstractProcess
{
    /**
     * @var string
     */
    protected string $responsePayload;

    /**
     * @param string $responsePayload
     */
    public function __construct(string $responsePayload)
    {
        $this->responsePayload = $responsePayload;
    }

    /**
     * @param AbstractRequestPayload $payload
     * @return AbstractResponsePayload
     */
    public function process($payload): AbstractResponsePayload
    {
        return new $this->responsePayload($payload);
    }
}
