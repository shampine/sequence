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

    /**
     * @param SampleUseService|null $sampleUseService
     */
    public function __construct(?SampleUseService $sampleUseService = null)
    {
        $this->pipelines = [
            self::SAMPLE_PIPELINE => static function(
                bool $validationFailure = false,
                bool $sequenceFailure = false
            ) use ($sampleUseService)
            {
                return (new Pipeline)
                    ->pipe(new ValidationExceptionProcess($validationFailure, $sampleUseService))
                    ->pipe(new SequenceExceptionProcess($sequenceFailure))
                    ->pipe(new HydrateResponsePayloadProcess(SampleResponsePayload::class));
            }
        ];

        $this->excludeWhenEmpty = [
            'empty_value',
        ];

        $this->excludeWhenNull = [
            'null_value',
        ];
    }
}
