<?php
declare(strict_types=1);

namespace Shampine\Sequence\Pipeline;

use League\Pipeline\Pipeline;
use Shampine\Sequence\Exceptions\SequenceException;
use Shampine\Sequence\Exceptions\ValidationException;
use Shampine\Sequence\Payload\AbstractRequestPayload;
use Shampine\Sequence\Payload\AbstractResponsePayload;

abstract class AbstractPipeline
{
    protected Pipeline $pipeline;
    protected AbstractRequestPayload $requestPayload;

    public function __construct(Pipeline $pipeline, AbstractRequestPayload $requestPayload)
    {
        $this->pipeline = $pipeline;
        $this->requestPayload = $requestPayload;
    }

    public function process(): AbstractResponsePayload
    {
        try {
            return $this->pipeline->process($this->requestPayload);
        } catch (ValidationException $validationException) {
            // @todo return error response payload
        } catch (SequenceException $sequenceException) {
            // @todo return error response payload
        }
    }
}
