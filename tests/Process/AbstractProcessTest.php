<?php
declare(strict_types=1);

namespace Process;

use PHPUnit\Framework\TestCase;
use Sample\SampleRequestPayload;
use Sample\SampleResponsePayload;
use Shampine\Sequence\Process\HydrateResponsePayloadProcess;

class AbstractProcessTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $process = new HydrateResponsePayloadProcess(SampleResponsePayload::class);

        $this->assertInstanceOf(HydrateResponsePayloadProcess::class, $process);
        $this->assertInstanceOf(SampleResponsePayload::class, $process->__invoke(new SampleRequestPayload()));
    }
}
