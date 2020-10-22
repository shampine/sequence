<?php
declare(strict_types=1);

namespace Shampine\Sequence\Payload;

interface ChildPipelineInterface
{
    public function getChildPipelineEntities(): array;
}
