<?php
declare(strict_types=1);

namespace Shampine\Sequence\Payload;

trait PatchTrait
{
    /**
     * @var bool
     */
    protected bool $isPatch = false;

    /**
     * @var array<string>
     */
    protected array $patch = [];

    /**
     * @return array<string>
     */
    public function getPatch(): array
    {
        return $this->patch;
    }

    /**
     * @param array<string> $patch
     * @return $this
     */
    public function setPatch(array $patch)
    {
        $this->isPatch = true;
        $this->patch = $patch;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPatch(): bool
    {
        return $this->isPatch;
    }

    /**
     * @param string $field
     * @return bool
     */
    public function hasPatchField(string $field): bool
    {
        return (in_array($field, $this->patch));
    }

    /**
     * @param string $field
     * @return $this
     */
    public function addPatchField(string $field)
    {
        $this->patch[] = $field;
        return $this;
    }
}
