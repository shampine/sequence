<?php
declare(strict_types=1);

namespace Shampine\Tests\Sample;

use Shampine\Sequence\Payload\ChildPipelineInterface;
use Shampine\Sequence\Payload\ChildPipelineTrait;

class SampleChildPipelinePayload extends SamplePayload implements ChildPipelineInterface
{
    use ChildPipelineTrait;
}
