<?php
declare(strict_types=1);

namespace Shampine\Tests\Response;

use PHPUnit\Framework\TestCase;
use Shampine\Tests\Sample\SamplePayload;
use Shampine\Tests\Sample\SampleResponse;

class GetterTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetter(): void
    {
        $payload = new SamplePayload();
        $payload->setAge(21);
        $payload->setName('Maxwell');
        $response = new SampleResponse($payload);

        $this->assertEquals('Maxwell is 21 years old.', $response->sampleAbout);
        $this->assertEquals('noGetterTestValue', $response->noGetterTestValue);
        $this->assertNull($response->noProperty);
    }
}
