<?php
declare(strict_types=1);

namespace Pipeline;

use PHPUnit\Framework\TestCase;
use Sample\SamplePipeline;
use Sample\SampleRequestPayload;
use Sample\SampleResponsePayload;

class PipelineTest extends TestCase
{
    /**
     * @return void
     */
    public function testSamplePipelineSuccess(): void
    {
        $payload = new SampleRequestPayload();
        $pipeline = new SamplePipeline();

        $response = $pipeline->process(SamplePipeline::SAMPLE_PIPELINE, $payload)->format();

        $this->assertInstanceOf(SampleResponsePayload::class, $response);
        $this->assertEquals('Maxwell is 99 years old.', $response->getSampleAbout());
    }
}
