<?php
declare(strict_types=1);

namespace Shampine\Sequence\Payload;

use Shampine\Sequence\Entity\ChildPipelineEntity;

trait ChildPipelineTrait
{
    /**
     * @var array<ChildPipelineEntity>
     */
    protected array $childPipelineEntities = [];

    /**
     * @return array<ChildPipelineEntity>
     */
    public function getChildPipelineEntities(): array
    {
        return $this->childPipelineEntities;
    }

    /**
     * @param array<ChildPipelineEntity> $childPipelineEntities
     * @return $this
     */
    public function setChildPipelineEntities(array $childPipelineEntities): self
    {
        $this->childPipelineEntities = $childPipelineEntities;
        return $this;
    }

    /**
     * @param ChildPipelineEntity $childPipelineEntity
     * @return $this
     */
    public function addChildPipelineEntity(ChildPipelineEntity $childPipelineEntity): self
    {
        $this->childPipelineEntities[] = $childPipelineEntity;
        return $this;
    }
}
