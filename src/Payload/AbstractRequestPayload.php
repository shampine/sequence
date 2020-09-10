<?php
declare(strict_types=1);

namespace Shampine\Sequence\Payload;

abstract class AbstractRequestPayload
{
    final public function hydratePost(array $post): self
    {
        return $this;
    }

    final public function hydratePatch(array $patch): self
    {

    }
}
