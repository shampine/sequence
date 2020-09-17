<?php
declare(strict_types=1);

namespace Response;

use PHPUnit\Framework\TestCase;
use Sample\SamplePayload;
use Sample\SampleResponse;

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

        echo $response->getSampleAbout();

        $this->assertEquals('Maxwell is 21 years old.', $response->sampleAbout);
        $this->assertEquals('noGetterTestValue', $response->noGetterTestValue);
        $this->assertNull($response->noProperty);
    }
}
