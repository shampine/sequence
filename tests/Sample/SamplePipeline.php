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
     * @param bool $validationFailure
     * @param bool $sequenceFailure
     */
    public function __construct(bool $validationFailure = false, bool $sequenceFailure = false)
    {
        $this->pipelines = [
            self::SAMPLE_PIPELINE => static function() use ($validationFailure, $sequenceFailure) {
                return (new Pipeline)
                    ->pipe(new ValidationExceptionProcess($validationFailure))
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
