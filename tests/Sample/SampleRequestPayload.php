<?php
declare(strict_types=1);

namespace Sample;

use Shampine\Sequence\Payload\AbstractRequestPayload;

class SampleRequestPayload extends AbstractRequestPayload
{
    /**
     * @var string
     */
    protected string $name = 'Maxwell';

    /**
     * @var int
     */
    protected int $age = 99;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     * @return $this
     */
    public function setAge(int $age): self
    {
        $this->age = $age;
        return $this;
    }
}
