<?php
declare(strict_types=1);

namespace Shampine\Sequence\Payload;

use Shampine\Sequence\Entity\ChildPipelineEntity;

interface ChildPipelineInterface
{
    /**
     * @return array<ChildPipelineEntity>
     */
    public function getChildPipelineEntities(): array;
}
