<?php
declare(strict_types=1);

namespace Pipeline;

use BadFunctionCallException;
use PHPUnit\Framework\TestCase;
use Sample\SamplePipeline;
use Sample\SampleRequestPayload;
use Shampine\Sequence\Payload\AbstractResponsePayload;
use Shampine\Sequence\Support\StatusCode;

class PipelineTest extends TestCase
{
    /**
     * @return void
     */
    public function testPipelineNameException(): void
    {
        self::expectException(BadFunctionCallException::class);

        $payload = new SampleRequestPayload();
        (new SamplePipeline())->process('DoesNotExist', $payload);
    }

    /**
     * @return void
     */
    public function testSamplePipelineSuccess(): void
    {
        $payload = new SampleRequestPayload();
        $pipeline = new SamplePipeline();

        $response = $pipeline->process(SamplePipeline::SAMPLE_PIPELINE, $payload)->format();

        self::assertIsArray($response);
        self::assertEquals(200, $response['status_code']);
        self::assertNull($response['error_code']);
        self::assertNull($response['message']);
        self::assertNull($response['error_messages']);
        self::assertEquals('Maxwell is 99 years old.', $response['data']['sample_about']);
    }

    /**
     * @return void
     */
    public function testSamplePipelineSuccessExcludeEmpty(): void
    {
        $payload = new SampleRequestPayload();
        $pipeline = new SamplePipeline();

        $response = $pipeline->process(SamplePipeline::SAMPLE_PIPELINE, $payload)->format();

        self::assertArrayNotHasKey('empty_value', $response['data']);
    }

    /**
     * @return void
     */
    public function testSamplePipelineSuccessExcludeNull(): void
    {
        $payload = new SampleRequestPayload();
        $pipeline = new SamplePipeline();

        $response = $pipeline->process(SamplePipeline::SAMPLE_PIPELINE, $payload)->format();

        self::assertArrayNotHasKey('null_value', $response['data']);
    }

    /**
     * @return void
     */
    public function testSamplePipelineSuccessCamelCase(): void
    {
        $payload = new SampleRequestPayload();
        $pipeline = new SamplePipeline();

        $response = $pipeline->process(SamplePipeline::SAMPLE_PIPELINE, $payload)->format(false);

        self::assertIsArray($response);
        self::assertEquals(200, $response['statusCode']);
        self::assertNull($response['errorCode']);
        self::assertNull($response['message']);
        self::assertNull($response['errorMessages']);
        self::assertEquals('Maxwell is 99 years old.', $response['data']['sampleAbout']);
    }

    /**
     * @return void
     */
    public function testSamplePipelineValidationFailure(): void
    {
        $payload = new SampleRequestPayload();
        $pipeline = new SamplePipeline(true, false);

        $response = $pipeline->process(SamplePipeline::SAMPLE_PIPELINE, $payload)->format();

        self::assertIsArray($response);
        self::assertEquals(StatusCode::BAD_REQUEST, $response['status_code']);
        self::assertEquals(9999, $response['error_code']);
        self::assertEquals('Validation error', $response['message']);
        self::assertIsArray($response['error_messages']);
        self::assertEquals(
            [
                'error' => 'validation failed',
                'fields' => [
                    'name' => 'undefined',
                ]
            ],
            $response['error_messages']
        );
        self::assertNull($response['data']);
    }

    /**
     * @return void
     */
    public function testSamplePipelineSequenceFailure(): void
    {
        $payload = new SampleRequestPayload();
        $pipeline = new SamplePipeline(false, true);

        $response = $pipeline->process(SamplePipeline::SAMPLE_PIPELINE, $payload)->format();

        self::assertIsArray($response);
        self::assertEquals(StatusCode::INTERNAL_SERVER_ERROR, $response['status_code']);
        self::assertEquals(6666, $response['error_code']);
        self::assertEquals('Something went horribly wrong', $response['message']);
        self::assertNull($response['error_messages']);
        self::assertNull($response['data']);
    }

    /**
     * @return void
     */
    public function testGetResponsePayload(): void
    {
        $payload = new SampleRequestPayload();
        $pipeline = (new SamplePipeline())->process(SamplePipeline::SAMPLE_PIPELINE, $payload);

        $this->assertInstanceOf(AbstractResponsePayload::class, $pipeline->getResponsePayload());
    }
}
