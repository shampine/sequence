<?php
declare(strict_types=1);

namespace Shampine\Sequence\Payload;

use RuntimeException;
use Shampine\Sequence\Support\Str;

abstract class AbstractPayload
{
    /**
     * @var array<string>
     */
    protected array $allowlist = [];

    /**
     * @var array<string>
     */
    protected array $overrides = [];

    /**
     * @param array<string> $overrides
     * @param array<string> $allowlist
     */
    public function __construct(array $allowlist = [], array $overrides = [])
    {
        $this->allowlist = $allowlist;
        $this->overrides = $overrides;
    }

    /**
     * @param array<mixed> $post
     * @return $this
     */
    final public function hydratePost(array $post = []): self
    {
        return $this->hydrate($post);
    }

    /**
     * @param array<mixed> $patch
     * @return $this
     */
    final public function hydratePatch(array $patch = []): self
    {
        if (!$this instanceof PatchInterface) {
            throw new RuntimeException('Payload must implement PatchInterface');
        }

        /** @var $this AbstractPayload */
        return $this->hydrate($patch, true);
    }

    /**
     * @param array<mixed> $query
     * @return $this
     */
    final public function hydratePagination(array $query = []): self
    {
        if (!$this instanceof PaginationInterface) {
            throw new RuntimeException('Payload must implement PaginationInterface');
        }

        if (isset($query[PaginationInterface::OFFSET])) {
            $this->setOffset((int) $query[PaginationInterface::OFFSET]);
        }

        if (isset($query[PaginationInterface::LIMIT])) {
            $this->setLimit((int) $query[PaginationInterface::LIMIT]);
        }

        if (isset($query[PaginationInterface::CURSOR])) {
            $this->setCursor((int) $query[PaginationInterface::CURSOR]);
        }

        return $this;
    }

    /**
     * @param array<mixed> $values
     * @param bool $isPatch
     * @return $this
     */
    protected function hydrate(array $values = [], bool $isPatch = false): self
    {
        $patchKeys = [];

        foreach ($values as $key => $value) {
            if (array_key_exists($key, $this->overrides)) {
                $key = $this->overrides[$key];
            }

            if (!in_array($key, $this->allowlist)) {
                continue;
            }

            $setter = Str::setter($key);

            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
                $patchKeys[] = $key;
            }
        }

        if ($this instanceof PatchInterface && $isPatch === true) {
            $this->setPatch($patchKeys);
        }

        return $this;
    }
}
