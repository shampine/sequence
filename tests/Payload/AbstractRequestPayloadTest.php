<?php
declare(strict_types=1);

namespace Payload;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sample\SampleNoPatchInterfacePayload;
use Sample\SamplePayload;

class AbstractRequestPayloadTest extends TestCase
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

        (new SampleNoPatchInterfacePayload())->hydratePatch();
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
