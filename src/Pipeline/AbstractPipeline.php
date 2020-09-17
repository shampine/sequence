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
use Shampine\Sequence\Response\ErrorResponse;
use Shampine\Sequence\Response\SuccessResponse;
use Shampine\Sequence\Support\Str;

abstract class AbstractPipeline
{
    /**
     * @var array<Closure>
     */
    protected array $pipelines = [];

    /**
     * @var array<string>
     */
    protected array $excludeWhenEmpty = [];

    /**
     * @var array<string>
     */
    protected array $excludeWhenNull = [];

    /**
     * @var AbstractResponsePayload|ErrorResponse
     */
    protected $responsePayload;

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
            $responsePayload = new ErrorResponse($validationException);
        } catch (SequenceException $sequenceException) {
            $responsePayload = new ErrorResponse($sequenceException);
        }

        $this->responsePayload = $responsePayload;
        return $this;
    }

    /**
     * @param bool $useSnakeCase
     * @return array<mixed>
     */
    public function format(bool $useSnakeCase = true): array
    {
        if ($this->responsePayload instanceof ErrorResponse) {
            $response = $this->responsePayload;
        } else {
            $response = (new SuccessResponse())->setData(
                $this->transform($this->responsePayload, $useSnakeCase)
            );
        }

        return $this->transform($response, $useSnakeCase);
    }

    /**
     * @param ErrorResponse|SuccessResponse|AbstractResponsePayload $class
     * @param bool $useSnakeCase
     * @return array<mixed>
     */
    protected function transform($class, bool $useSnakeCase = true): array
    {
        $reflectionClass = new ReflectionClass($class);
        $properties = $reflectionClass->getProperties();
        $transformedClass = [];

        foreach ($properties as &$property) {
            $propertyName = $property->name;
            $snakeCasePropertyName = Str::snakeCase($propertyName);
            $transformKey = ($useSnakeCase) ? $snakeCasePropertyName : $propertyName;
            $propertyValue = $class->{$propertyName};

            if (in_array($snakeCasePropertyName, $this->excludeWhenEmpty) && empty($propertyValue)) {
                continue;
            }

            if (in_array($snakeCasePropertyName, $this->excludeWhenNull) && $propertyValue === null) {
                continue;
            }

            $transformedClass[$transformKey] = $propertyValue;
        }

        return $transformedClass;
    }

    /**
     * @return AbstractResponsePayload|ErrorResponse
     */
    public function getResponsePayload()
    {
        return $this->responsePayload;
    }
}
