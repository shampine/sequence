<?php
declare(strict_types=1);

namespace Shampine\Sequence\Pipeline;

use BadFunctionCallException;
use Closure;
use League\Pipeline\Pipeline;
use ReflectionClass;
use Shampine\Sequence\Exceptions\SequenceException;
use Shampine\Sequence\Exceptions\ValidationException;
use Shampine\Sequence\Payload\AbstractRequestPayload;
use Shampine\Sequence\Payload\AbstractResponsePayload;
use Shampine\Sequence\Payload\ErrorResponsePayload;

abstract class AbstractPipeline
{
    /**
     * @var array<Closure>
     */
    protected array $pipelines = [];

    /**
     * @var array
     */
    protected array $excludeWhenEmpty = [];

    /**
     * @var array
     */
    protected array $excludeWhenNull = [];

    /**
     * @var AbstractResponsePayload
     */
    protected AbstractResponsePayload $responsePayload;

    /**
     * @param string $pipelineName
     * @param AbstractRequestPayload $requestPayload
     * @param mixed ...$arguments
     * @return $this
     */
    public function process(string $pipelineName, AbstractRequestPayload $requestPayload, ...$arguments): self
    {
        if (!isset($this->pipelines[$pipelineName])) {
            throw new BadFunctionCallException('Pipeline name provided does not exist in pipelines.');
        }

        /** @var Pipeline $pipeline */
        $pipeline = $this->pipelines[$pipelineName](...$arguments);

        try {
            $responsePayload = $pipeline->process($requestPayload);
        } catch (ValidationException $validationException) {
            $responsePayload = new ErrorResponsePayload($validationException);
        } catch (SequenceException $sequenceException) {
            $responsePayload = new ErrorResponsePayload($sequenceException);
        }

        $this->responsePayload = $responsePayload;
        return $this;
    }

    /**
     * @param bool $useSnakeCase
     * @return AbstractResponsePayload
     */
    public function format(bool $useSnakeCase = false)
    {
        $reflectionClass = new ReflectionClass($this->responsePayload);
        $properties = $reflectionClass->getProperties();

        foreach ($properties as &$property) {
            $propertyName = $property->name;


            if (isset($this->excludeWhenEmpty[$propertyName]) && empty($this->responsePayload->{$propertyName})) {
                unset($this->responsePayload->{$propertyName});
                continue;
            }

            if (isset($this->excludeWhenNull[$propertyName]) && $this->responsePayload->{$propertyName} === null) {
                unset($this->responsePayload->{$propertyName});
                continue;
            }

            if ($useSnakeCase === false) {
                continue;
            }

            $propertySnakeCase = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $propertyName));

            if ($propertySnakeCase !== $propertyName) {
                $this->responsePayload->{$propertySnakeCase} = $this->responsePayload->{$propertyName};
                unset($this->responsePayload->{$propertyName});
            }
        }

        return $this->responsePayload;
    }
}
