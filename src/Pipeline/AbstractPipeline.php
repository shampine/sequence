<?php
declare(strict_types=1);

namespace Shampine\Sequence\Pipeline;

use BadFunctionCallException;
use Closure;
use League\Pipeline\Pipeline;
use ReflectionClass;
use Shampine\Sequence\Exceptions\SequenceException;
use Shampine\Sequence\Exceptions\ValidationException;
use Shampine\Sequence\Payload\AbstractPayload;
use Shampine\Sequence\Response\AbstractResponse;
use Shampine\Sequence\Response\ErrorResponseWrapper;
use Shampine\Sequence\Response\SuccessResponseWrapper;
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
     * @var AbstractResponse|ErrorResponseWrapper
     */
    protected $response;

    /**
     * @param string $pipelineName
     * @param AbstractPayload $payload
     * @param mixed ...$arguments
     * @return $this
     */
    public function process(string $pipelineName, AbstractPayload $payload, ...$arguments): self
    {
        if (!isset($this->pipelines[$pipelineName])) {
            throw new BadFunctionCallException('Pipeline name provided does not exist in pipelines.');
        }

        /** @var Pipeline $pipeline */
        $pipeline = $this->pipelines[$pipelineName](...$arguments);

        try {
            $response = $pipeline->process($payload);
        } catch (ValidationException $validationException) {
            $response = new ErrorResponseWrapper($validationException);
        } catch (SequenceException $sequenceException) {
            $response = new ErrorResponseWrapper($sequenceException);
        }

        $this->response = $response;
        return $this;
    }

    /**
     * @param bool $useSnakeCase
     * @return array<mixed>
     */
    public function format(bool $useSnakeCase = true): array
    {
        if ($this->response instanceof ErrorResponseWrapper) {
            $response = $this->response;
        } else {
            $response = (new SuccessResponseWrapper())->setData(
                $this->transform($this->response, $useSnakeCase)
            );
        }

        return $this->transform($response, $useSnakeCase);
    }

    /**
     * @param ErrorResponseWrapper|SuccessResponseWrapper|AbstractResponse $class
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
     * @return AbstractResponse|ErrorResponseWrapper
     */
    public function getResponse()
    {
        return $this->response;
    }
}
