# sequence
![example workflow name](https://github.com/shampine/sequence/workflows/Sequence%20Build/badge.svg)

An end to end api pipeline package.

## installation

`composer require shampine/sequence`

## usage

These examples are using Laravel conventions but this package is framework agnostic.

See these three files for verbose usage examples and live demos inside the phpunit tests.

[Sample RequestPayload](https://github.com/shampine/sequence/blob/master/tests/Sample/SampleRequestPayload.php)  
[Sample ResponsePayload](https://github.com/shampine/sequence/blob/master/tests/Sample/SampleResponsePayload.php)  
[Sample Pipeline](https://github.com/shampine/sequence/blob/master/tests/Sample/SamplePipeline.php)  

### Request Payloads

@TODO

When defining your RequestPayloads you can optionally define a `$whitelist` and `$overrides`.

```
$payload = new SampleRequestPayload($whitelist, $overrides);
```

The whitelist will limit what user supplied input will be hydrate into the RequestPayload. The overrides allows mapping
of different external keys to internal keys. Example is that the post contains `email_address` but on the payload the 
method is called `setEmail`. Mapping `['email_address' => 'email']` which properly align hydration.


### Pipeline Instantiation

A pipeline can have multiple closures available. This will allow grouping of similars pipelines together. You can
pass attributes into the pipeline either thru the class constructor OR the closure constructor.

Services, repositories, and other dependency injectable parameters are best set by using the class constructor. While
flags and other stage related properties can be injected using `->process($pipelineName, $payload, ...$argments)`.

```
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
```

### Response Payloads

Response payloads are the final output containers and should be hydrated in the final stage of a pipeline. All properties
on the class are REQUIRED to have a getter and setter.

```

public function __construct(SampleRequestPayload $payload)
{
    $this->setSampleAbout('This is an about statement.');
}
```

During the format process `getSampleAbout` would be used to compile the final array that will be returned as json.


### Controller Instantiation

Using Laravel dependency injection on your controller to instantiate the pipeline.

```
public function __construct(SamplePipeline $samplePipeline)
{
    $this-samplePipeline = $samplePipeline;
}
```

#### GET
```
public function get(Request $request)
{
    $payload = new SampleRequestPayload();
    $response = $this->samplePipeline->process(SamplePipeline::SAMPLE_PIPELINE, $payload)->format();

    return response()->json($response, $responde['http_code']);
}
```

#### POST
```
public function get(Request $request)
{
    $payload = (new SampleRequestPayload())->hydratePost($request->all());
    $response = $this->samplePipeline->process(SamplePipeline::SAMPLE_PIPELINE, $payload)->format();

    return response()->json($response, $responde['http_code']);
}
```

#### PATCH
```
public function get(Request $request)
{
    $payload = (new SampleRequestPayload())->hydratePatch($request->all());
    $response = $this->samplePipeline->process(SamplePipeline::SAMPLE_PIPELINE, $payload)->format();

    return response()->json($response, $responde['http_code']);
}
```

## testing

To run all tests run `./tests/run.sh`.

This will execute:

 - phpstan level 8
 - phpunit with code coverage (expects 100% coverage)

## license

MIT
