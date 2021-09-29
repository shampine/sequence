<?php
declare(strict_types=1);

namespace Shampine\Tests\Process;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Shampine\Sequence\Process\HydrateResponseProcess;
use Shampine\Tests\Sample\SamplePayload;
use Shampine\Tests\Sample\SamplePipeline;
use Shampine\Tests\Sample\SampleResponse;

class AbstractProcessTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $process = new HydrateResponseProcess(SampleResponse::class);

        $this->assertInstanceOf(HydrateResponseProcess::class, $process);
        $this->assertInstanceOf(SampleResponse::class, $process->__invoke(new SamplePayload()));
    }

    /**
     * @return void
     */
    public function testPipelineNameException(): void
    {
        self::expectException(RuntimeException::class);

        $payload = new SamplePayload();
        (new SamplePipeline())->process(SamplePipeline::SAMPLE_NO_PROCESS_PIPELINE, $payload);
    }
}
