<?php
declare(strict_types=1);

namespace Shampine\Sequence\Payload;

trait PaginationTrait
{
    /**
     * @var int
     */
    protected int $offset;

    /**
     * @var int
     */
    protected int $limit;

    /**
     * @var int
     */
    protected int $cursor;

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function setOffset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function setLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return int
     */
    public function getCursor(): int
    {
        return $this->cursor;
    }

    /**
     * @param int $cursor
     * @return $this
     */
    public function setCursor(int $cursor): self
    {
        $this->cursor = $cursor;
        return $this;
    }
}
