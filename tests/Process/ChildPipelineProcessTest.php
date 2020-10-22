<?php
declare(strict_types=1);

namespace Shampine\Tests\Process;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Shampine\Sequence\Entity\ChildPipelineEntity;
use Shampine\Sequence\Support\StatusCode;
use Shampine\Tests\Sample\SampleChildPipelinePayload;
use Shampine\Tests\Sample\SamplePayload;
use Shampine\Tests\Sample\SamplePipeline;
use Shampine\Tests\Sample\SampleResponse;

class ChildPipelineProcessTest extends TestCase
{
    public function testPayloadInstanceOfException(): void
    {
        self::expectException(RuntimeException::class);

        $payload = new SamplePayload();
        (new SamplePipeline())->process(SamplePipeline::SAMPLE_CHILD_PIPELINE, $payload);
    }

    public function testSuccessSkipChildPipeline(): void
    {
        $payload = new SampleChildPipelinePayload();

        $response = (new SamplePipeline())->process(SamplePipeline::SAMPLE_CHILD_PIPELINE, $payload)->format();

        self::assertIsArray($response);
        self::assertEquals(200, $response['status_code']);
        self::assertNull($response['error_code']);
        self::assertNull($response['message']);
        self::assertNull($response['error_messages']);
        self::assertEquals('Maxwell is 99 years old.', $response['data']['sample_about']);
    }

    public function testChildPipelineAdjustAge(): void
    {
        $childPipelineEntity = new ChildPipelineEntity();
        $childPipelineEntity->setPayload(new SamplePayload());
        $childPipelineEntity->setPipelineClass(new SamplePipeline());
        $childPipelineEntity->setPipelineName(SamplePipeline::SAMPLE_PIPELINE);
        $childPipelineEntity->setCallback(static function(SampleChildPipelinePayload $payload, SampleResponse $response) {
            preg_match('/\d{2}/', $response->getSampleAbout(), $matches);
            $payload->setAge((int) $matches[0]);
            return $payload;
        });

        $payload = new SampleChildPipelinePayload();
        $payload->addChildPipelineEntity($childPipelineEntity);
        $payload->setAge(999999);

        $response = (new SamplePipeline())->process(SamplePipeline::SAMPLE_CHILD_PIPELINE, $payload)->format();

        self::assertIsArray($response);
        self::assertEquals(200, $response['status_code']);
        self::assertNull($response['error_code']);
        self::assertNull($response['message']);
        self::assertNull($response['error_messages']);
        self::assertEquals('Maxwell is 99 years old.', $response['data']['sample_about']);
    }

    public function testChildPipelineSuppressErrors(): void
    {
        $childPipelineEntity = new ChildPipelineEntity();
        $childPipelineEntity->setPayload(new SamplePayload());
        $childPipelineEntity->setPipelineClass(new SamplePipeline());
        $childPipelineEntity->setPipelineName(SamplePipeline::SAMPLE_PIPELINE);
        $childPipelineEntity->setSuppressErrors(true);
        $childPipelineEntity->setArguments([true]);

        $payload = new SampleChildPipelinePayload();
        $payload->setChildPipelineEntities([$childPipelineEntity]);
        $payload->setAge(999999);

        $response = (new SamplePipeline())->process(SamplePipeline::SAMPLE_CHILD_PIPELINE, $payload)->format();

        self::assertIsArray($response);
        self::assertEquals(200, $response['status_code']);
        self::assertNull($response['error_code']);
        self::assertNull($response['message']);
        self::assertNull($response['error_messages']);
        self::assertEquals('Maxwell is 999999 years old.', $response['data']['sample_about']);
    }

    public function testChildPipelineBubbleErrors(): void
    {
        $childPipelineEntity = new ChildPipelineEntity();
        $childPipelineEntity->setPayload(new SamplePayload());
        $childPipelineEntity->setPipelineClass(new SamplePipeline());
        $childPipelineEntity->setPipelineName(SamplePipeline::SAMPLE_PIPELINE);
        $childPipelineEntity->setSuppressErrors(false);
        $childPipelineEntity->setArguments([true]);

        $payload = new SampleChildPipelinePayload();
        $payload->setChildPipelineEntities([$childPipelineEntity]);

        $response = (new SamplePipeline())->process(SamplePipeline::SAMPLE_CHILD_PIPELINE, $payload)->format();

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
}
