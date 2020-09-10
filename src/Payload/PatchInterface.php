<?php
declare(strict_types=1);

namespace Shampine\Sequence\Payload;

interface PatchInterface
{
    public function getPatch(): array;
    public function setPatch(array $patch);
    public function isPatch(): bool;
}
