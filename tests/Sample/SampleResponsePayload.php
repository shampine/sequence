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
}