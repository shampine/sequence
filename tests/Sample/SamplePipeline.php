<?php
declare(strict_types=1);

namespace Shampine\Tests\Sample;

use League\Pipeline\Pipeline;
use Shampine\Sequence\Pipeline\AbstractPipeline;
use Shampine\Sequence\Process\ChildPipelineProcess;
use Shampine\Sequence\Process\HydrateResponseProcess;

class SamplePipeline extends AbstractPipeline
{
    /**
     * @constant string
     */
    public const SAMPLE_PIPELINE = 'SamplePipeline';

    public const SAMPLE_CHILD_PIPELINE = 'SampleChildPipeline';

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
                    ->pipe(new HydrateResponseProcess(SampleResponse::class));
            },
            self::SAMPLE_CHILD_PIPELINE => static function()
            {
                return (new Pipeline)
                    ->pipe(new ChildPipelineProcess())
                    ->pipe(new HydrateResponseProcess(SampleResponse::class));

            },
        ];

        $this->excludeWhenEmpty = [
            'empty_value',
        ];

        $this->excludeWhenNull = [
            'null_value',
        ];
    }
}
