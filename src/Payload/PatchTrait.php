<?php
declare(strict_types=1);

namespace Shampine\Sequence\Payload;

trait PatchTrait
{
    protected bool $isPatch = false;
    protected array $patch = [];

    public function getPatch(): array
    {
        return $this->patch;
    }

    public function setPatch(array $patch)
    {
        $this->isPatch = true;
        $this->patch = $patch;
        return $this;
    }

    public function isPatch(): bool
    {
        return $this->isPatch;
    }
}
