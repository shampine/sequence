<?php
declare(strict_types=1);

namespace Shampine\Tests\Sample;

use Shampine\Sequence\Payload\AbstractPayload;
use Shampine\Sequence\Payload\PatchInterface;
use Shampine\Sequence\Payload\PatchTrait;

class SamplePayload extends AbstractPayload implements PatchInterface
{
    use PatchTrait;

    /**
     * @constant array<string>
     */
    public const WHITELIST = [
        'name',
        'age',
    ];

    /**
     * @constant array<string>
     */
    public const OVERRIDES = [
        'years' => 'age',
    ];

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
