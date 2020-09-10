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
    protected array $pipelines = [];
    protected AbstractRequestPayload $requestPayload;

    public function __construct( AbstractRequestPayload $requestPayload)
    {
        $this->requestPayload = $requestPayload;
    }

    public function process(string $pipelineName): AbstractResponsePayload
    {
        if (!isset($this->pipelines[$pipelineName])) {
            throw new SequenceException('Pipeline provided does not exist in pipelines.');
        }

        $pipeline = $this->pipelines[$pipelineName];

        try {
            return $pipeline->process($this->requestPayload);
        } catch (ValidationException $validationException) {
            // @todo return error response payload
        } catch (SequenceException $sequenceException) {
            // @todo return error response payload
        }
    }
}
