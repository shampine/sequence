<?php
declare(strict_types=1);

namespace Shampine\Tests\Payload;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Shampine\Sequence\Payload\PaginationInterface;
use Shampine\Tests\Sample\SampleNoInterfacePayload;
use Shampine\Tests\Sample\SamplePayload;

class AbstractPayloadTest extends TestCase
{
    /**
     * @return void
     */
    public function testPost(): void
    {
        $payload = (new SamplePayload(SamplePayload::WHITELIST))->hydratePost(
            [
                'name' => 'Maxwell Namerson',
                'age' => 21,
                'skip' => true,
            ]
        );

        self::assertEquals('Maxwell Namerson', $payload->getName());
        self::assertEquals(21, $payload->getAge());
        self::assertFalse($payload->isPatch());
        self::assertEmpty($payload->getPatch());
    }

    /**
     * @return void
     */
    public function testPatchException(): void
    {
        self::expectException(RuntimeException::class);

        (new SampleNoInterfacePayload())->hydratePatch();
    }

    /**
     * @return void
     */
    public function testPatch(): void
    {
        $payload = (new SamplePayload(SamplePayload::WHITELIST))->hydratePatch(
            [
                'name' => 'Maxwell Namerson',
                'age' => 21,
                'skip' => true,
            ]
        );

        self::assertEquals('Maxwell Namerson', $payload->getName());
        self::assertEquals(21, $payload->getAge());
        self::assertTrue($payload->isPatch());
        self::assertEquals(['name', 'age'], $payload->getPatch());
    }

    public function testPaginationException(): void
    {
        self::expectException(RuntimeException::class);

        (new SampleNoInterfacePayload())->hydratePagination();
    }

    public function testPagination(): void
    {
        $payload = (new SamplePayload())->hydratePagination(
            [
                PaginationInterface::OFFSET => 111,
                PaginationInterface::LIMIT  => 222,
                PaginationInterface::CURSOR => 333,
            ]
        );

        self::assertEquals(111, $payload->getOffset());
        self::assertEquals(222, $payload->getLimit());
        self::assertEquals(333, $payload->getCursor());
    }

    /**
     * @return void
     */
    public function testWhitelist(): void
    {
        $payload = (new SamplePayload(['name']))->hydratePost(
            [
                'name' => 'Maxwell Namerson',
                'age' => 21,
                'skip' => true,
            ]
        );

        self::assertEquals('Maxwell Namerson', $payload->getName());
        self::assertEquals(99, $payload->getAge());
    }

    /**
     * @return void
     */
    public function testOverrides(): void
    {
        $payload = new SamplePayload(SamplePayload::WHITELIST, SamplePayload::OVERRIDES);
        $payload->hydratePost(
            [
                'name' => 'Maxwell Namerson',
                'skip' => true,
                'years' => 21,
            ]
        );

        self::assertEquals('Maxwell Namerson', $payload->getName());
        self::assertEquals(21, $payload->getAge());
    }
}
