<?php
declare(strict_types=1);

namespace Shampine\Tests\Process;

use PHPUnit\Framework\TestCase;
use Shampine\Sequence\Process\HydrateResponsePayloadProcess;
use Shampine\Tests\Sample\SamplePayload;
use Shampine\Tests\Sample\SampleResponse;

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
