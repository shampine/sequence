<?php
declare(strict_types=1);

namespace Shampine\Sequence\Payload;

interface PatchInterface
{
    /**
     * @return array<string>
     */
    public function getPatch(): array;

    /**
     * @param array<string> $patch
     * @return self
     */
    public function setPatch(array $patch);

    /**
     * @return bool
     */
    public function isPatch(): bool;
}
