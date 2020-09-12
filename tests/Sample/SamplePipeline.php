<?php
declare(strict_types=1);

namespace Sample;

use League\Pipeline\Pipeline;
use Shampine\Sequence\Pipeline\AbstractPipeline;
use Shampine\Sequence\Process\HydrateResponsePayloadProcess;

class SamplePipeline extends AbstractPipeline
{
    /**
     * @constant string
     */
    public const SAMPLE_PIPELINE = 'SamplePipeline';

    public function __construct()
    {
        $this->pipelines = [
            self::SAMPLE_PIPELINE => static function() {
                return (new Pipeline)
                    ->pipe(new ValidationExceptionProcess())
                    ->pipe(new SequenceExceptionProcess())
                    ->pipe(new HydrateResponsePayloadProcess(SampleResponsePayload::class));
            }
        ];
    }
}
