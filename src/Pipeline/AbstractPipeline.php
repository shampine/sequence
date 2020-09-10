<?php
declare(strict_types=1);

namespace Shampine\Sequence\Pipeline;

use Shampine\Sequence\Exceptions\SequenceException;
use Shampine\Sequence\Exceptions\ValidationException;
use Shampine\Sequence\Payload\AbstractRequestPayload;
use Shampine\Sequence\Payload\AbstractResponsePayload;

abstract class AbstractPipeline
{
    protected array $pipelines = [];

    public function process(string $pipelineName, AbstractRequestPayload $requestPayload): AbstractResponsePayload
    {
        if (!isset($this->pipelines[$pipelineName])) {
            throw new SequenceException('Pipeline name provided does not exist in pipelines.');
        }

        $pipeline = $this->pipelines[$pipelineName];

        try {
            return $pipeline->process($requestPayload);
        } catch (ValidationException $validationException) {
            // @todo return error response payload
        } catch (SequenceException $sequenceException) {
            // @todo return error response payload
        }
    }

    public function format()
    {

    }

    public function toArray()
    {

    }

    public function toJson()
    {

    }
}
