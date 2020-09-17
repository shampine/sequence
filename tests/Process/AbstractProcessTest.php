<?php
declare(strict_types=1);

namespace Process;

use PHPUnit\Framework\TestCase;
use Sample\SamplePayload;
use Sample\SampleResponse;
use Shampine\Sequence\Process\HydrateResponsePayloadProcess;

class AbstractProcessTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $process = new HydrateResponsePayloadProcess(SampleResponse::class);

        $this->assertInstanceOf(HydrateResponsePayloadProcess::class, $process);
        $this->assertInstanceOf(SampleResponse::class, $process->__invoke(new SamplePayload()));
    }
}
