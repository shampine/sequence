<?php
declare(strict_types=1);

namespace Sample;

use Shampine\Sequence\Payload\AbstractResponsePayload;

class SampleResponsePayload extends AbstractResponsePayload
{
    /**
     * @var string
     */
    protected string $sampleAbout = '';

    /**
     * @var string|null
     */
    protected ?string $emptyValue = null;

    /**
     * @var string|null
     */
    protected ?string $nullValue = null;

    /**
     * @param SampleRequestPayload $payload
     */
    public function __construct(SampleRequestPayload $payload)
    {
        $this->setSampleAbout($payload->getName() . ' is ' . $payload->getAge() . ' years old.');
    }

    /**
     * @return string
     */
    public function getSampleAbout(): string
    {
        return $this->sampleAbout;
    }

    /**
     * @param string $sampleAbout
     * @return $this;
     */
    public function setSampleAbout(string $sampleAbout): self
    {
        $this->sampleAbout = $sampleAbout;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmptyValue(): ?string
    {
        return $this->emptyValue;
    }

    /**
     * @param string|null $emptyValue
     * @return $this
     */
    public function setEmptyValue(?string $emptyValue): self
    {
        $this->emptyValue = $emptyValue;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNullValue(): ?string
    {
        return $this->nullValue;
    }

    /**
     * @param string|null $nullValue
     * @return $this
     */
    public function setNullValue(?string $nullValue): self
    {
        $this->nullValue = $nullValue;
        return $this;
    }
}
