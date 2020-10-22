<?php
declare(strict_types=1);

namespace Shampine\Sequence\Entity;

use Closure;
use Shampine\Sequence\Payload\AbstractPayload;
use Shampine\Sequence\Pipeline\AbstractPipeline;

class ChildPipelineEntity
{
    /**
     * @var AbstractPayload
     */
    protected AbstractPayload $payload;

    /**
     * @var AbstractPipeline
     */
    protected AbstractPipeline $pipelineClass;

    /**
     * @var string
     */
    protected string $pipelineName;

    /**
     * @var array<mixed>
     */
    protected array $arguments = [];

    /**
     * @var Closure|null
     */
    protected ?Closure $callback = null;

    /**
     * @var bool
     */
    protected bool $suppressErrors = false;

    /**
     * @return AbstractPayload
     */
    public function getPayload(): AbstractPayload
    {
        return $this->payload;
    }

    /**
     * @param AbstractPayload $payload
     * @return $this
     */
    public function setPayload(AbstractPayload $payload): self
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @return AbstractPipeline
     */
    public function getPipelineClass(): AbstractPipeline
    {
        return $this->pipelineClass;
    }

    /**
     * @param AbstractPipeline $pipelineClass
     * @return $this
     */
    public function setPipelineClass(AbstractPipeline $pipelineClass): self
    {
        $this->pipelineClass = $pipelineClass;
        return $this;
    }

    /**
     * @return string
     */
    public function getPipelineName(): string
    {
        return $this->pipelineName;
    }

    /**
     * @param string $pipelineName
     * @return $this
     */
    public function setPipelineName(string $pipelineName): self
    {
        $this->pipelineName = $pipelineName;
        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param array<mixed> $arguments
     * @return $this
     */
    public function setArguments(array $arguments): self
    {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * @return Closure|null
     */
    public function getCallback(): ?Closure
    {
        return $this->callback;
    }

    /**
     * @param Closure|null $callback
     * @return $this
     */
    public function setCallback(?Closure $callback): self
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @return bool
     */
    public function getSuppressErrors(): bool
    {
        return $this->suppressErrors;
    }

    /**
     * @param bool $suppressErrors
     * @return $this
     */
    public function setSuppressErrors(bool $suppressErrors): self
    {
        $this->suppressErrors = $suppressErrors;
        return $this;
    }
}
