<?php
declare(strict_types=1);

namespace Shampine\Sequence\Payload;

use Shampine\Sequence\Exceptions\SequenceException;

abstract class AbstractRequestPayload
{
    protected array $overrides = [];
    protected array $whitelist = [];

    final public function hydratePost(array $post = []): self
    {
        $this->hydrate($post);
        return $this;
    }

    final public function hydratePatch(array $patch = []): self
    {
        if ($this instanceof PatchInterface) {
            throw new SequenceException('Payload must implement PatchInterface');
        }

        $this->hydrate($patch);
        return $this;
    }

    /**
     * @param array $values
     */
    protected function hydrate($values = []): void
    {
        $patchKeys = [];

        foreach ($values as $key => $value) {
            if (!array_key_exists($key, $this->whitelist)) {
                continue;
            }

            if (array_key_exists($key, $this->overrides)) {
                $key = $this->overrides[$key];
            }

            $setter = "set" . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
                $patchKeys[] = $key;
            }
        }

        if (method_exists($this, 'setPatch')) {
            $this->setPatch($patchKeys);
        }
    }
}
