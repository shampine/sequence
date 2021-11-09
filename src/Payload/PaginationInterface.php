<?php
declare(strict_types=1);

namespace Shampine\Sequence\Payload;

interface PaginationInterface
{
    /**
     * @constant string
     */
    public const OFFSET = 'offset';

    /**
     * @constant string
     */
    public const LIMIT = 'limit';

    /**
     * @constant string
     */
    public const CURSOR = 'cursor';

    public function getOffset(): int;
    public function setOffset(int $offset): PaginationInterface;
    public function getLimit(): int;
    public function setLimit(int $limit): PaginationInterface;
    public function getCursor(): int;
    public function setCursor(int $cursor): PaginationInterface;
}
