<?php
declare(strict_types=1);

namespace Shampine\Sequence\Pipeline;

use BadFunctionCallException;
use Shampine\Sequence\Exceptions\SequenceException;
use Shampine\Sequence\Exceptions\ValidationException;
use Shampine\Sequence\Payload\AbstractRequestPayload;
use Shampine\Sequence\Payload\AbstractResponsePayload;
use Shampine\Sequence\Payload\ErrorResponsePayload;

abstract class AbstractPipeline
{
    /**
     * @var array
     */
    protected array $pipelines = [];

    /**
     * @param string $pipelineName
     * @param AbstractRequestPayload $requestPayload
     * @return AbstractResponsePayload
     */
    public function process(string $pipelineName, AbstractRequestPayload $requestPayload): AbstractResponsePayload
    {
        if (!isset($this->pipelines[$pipelineName])) {
            throw new BadFunctionCallException('Pipeline name provided does not exist in pipelines.');
        }

        $pipeline = $this->pipelines[$pipelineName];

        try {
            return $pipeline->process($requestPayload);
        } catch (ValidationException $validationException) {
            return new ErrorResponsePayload($validationException);
        } catch (SequenceException $sequenceException) {
            return new ErrorResponsePayload($sequenceException);
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
