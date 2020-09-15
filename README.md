# sequence
![example workflow name](https://github.com/shampine/sequence/workflows/Sequence%20Build/badge.svg)

A framework agnostic pipelining package to handle complete requests.

[Laravel Demo - https://github.com/shampine/sequence-demo](https://github.com/shampine/sequence-demo)  
[Tutorial - https://medium.com/gosteady/day-5-sequence-how-to-guide-56c0af1b2303](https://medium.com/gosteady/day-5-sequence-how-to-guide-56c0af1b2303)  

## why

Using the pipeline pattern developers can move quickly, recycle processes, and test everything.

![pipeline diagram](https://raw.githubusercontent.com/shampine/sequence/master/diagram.png)

Benefits to using pipelines for an MVC framework include

 - skinny and consistent controllers  
 - ability to share processes amongst different pipelines
 - simple injection of service or repository classes into the processes to keep code clean
 - ease of testing individual processes
 - clear, consistent api responses
 - eliminate need to try/catch exceptions inside the stack

## installation

`composer require shampine/sequence`

## usage

These examples are using Laravel conventions but this package is framework agnostic.

See these three files for verbose usage examples and live demos inside the phpunit tests.

[Sample RequestPayload](https://github.com/shampine/sequence/blob/master/tests/Sample/SampleRequestPayload.php)  
[Sample ResponsePayload](https://github.com/shampine/sequence/blob/master/tests/Sample/SampleResponsePayload.php)  
[Sample Pipeline](https://github.com/shampine/sequence/blob/master/tests/Sample/SamplePipeline.php)  

### Request Payloads

This is the active workspace. The request payload is mutated as it passes thru each stage. Any data needed from one
stage to another needs to be set on the payload, and then retrieved from the payload.

When defining your RequestPayloads you can optionally define a `$whitelist` and `$overrides`.

```php
$payload = new SampleRequestPayload($whitelist, $overrides);
```

A whitelist will limit what user supplied input will be hydrated into the RequestPayload. The overrides parameter allows
mapping of different external keys to internal keys. E.g. if the post contains `email_address` but on the payload the 
method is called `setEmail`. Mapping `['email_address' => 'email']` will properly align hydration.

### Pipeline Composition

A pipeline can have multiple named closures stored in the `$pipelines` property. This will allow grouping of similar
pipelines together. You can pass attributes into the pipeline either thru the class constructor OR the closure constructor.

Services, repositories, and other dependency injectable parameters are best set by using the class constructor. While
flags and other stage related properties can be injected using `->process($pipelineName, $payload, ...$argments)`.

This example pipeline has a service injected into the constructor but two boolean flags passed through the $arguments
parameter on `->process()`.

```php
class SamplePipeline extends AbstractPipeline
{
    public const SAMPLE_PIPELINE = 'SamplePipeline';

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

The property `$excludeWhenEmpty` or `$excludeWhenNull` will check ANY root or data keys to see if their value is
`empty()` or `=== null`. If so they are excluded from the final array, all keys should use `snake_case`.

### Response Payloads

Response payloads are the final output containers and should be hydrated in the final stage of a pipeline. All properties
on the class are REQUIRED to have a getter and setter.

```php
public function __construct(SampleRequestPayload $payload)
{
    $this->setSampleAbout('This is an about statement.');
}
```

During the format process `getSampleAbout` would be used to compile the final array that will be returned as json.

### Controller Examples (Laravel)

Using dependency injection on your controller to instantiate the pipeline.

```php
class SampleController
{
    public function __construct(SamplePipeline $samplePipeline)
    {
        $this-samplePipeline = $samplePipeline;
    }
}
```

#### GET

```php
public function get(Request $request)
{
    $payload = new SampleRequestPayload();
    $response = $this->samplePipeline->process(SamplePipeline::SAMPLE_PIPELINE, $payload)->format();

    return response()->json($response, $responde['http_code']);
}
```

#### POST

```php
public function post(Request $request)
{
    $payload = (new SampleRequestPayload())->hydratePost($request->all());
    $response = $this->samplePipeline->process(SamplePipeline::SAMPLE_PIPELINE, $payload)->format();

    return response()->json($response, $responde['http_code']);
}
```

#### PATCH
Patch requests payloads require the `PatchInterface` and `PatchTrait`. The payload will contain methods to decipher what
is requested to be patched `->getPatch()` and whether the payload is a patch request `->isPatch()`.

```php
public function patch(Request $request)
{
    $payload = (new SampleRequestPayload())->hydratePatch($request->all());
    $response = $this->samplePipeline->process(SamplePipeline::SAMPLE_PIPELINE, $payload)->format();

    return response()->json($response, $responde['http_code']);
}
```

### Exceptions

Included are two exceptions, ValidationException and SequenceException. Both are caught and rendered to json. You can
define specific exception by extending these classes. They are caught and rendered the same as a normal payload to easily
allow json to be return.

```php
class Fetchuser extends AbstractProcess
{
    public function process()
    {
        $user = $this->userService->getUserRepository()->fetchUserById($id);

        if ($user === null) {
            throw new SequenceException(1000, 'User not found', 400);
        }
    
        $payload->setUser($user);

        return $payload;
    }
}
```

A null user returns

```php
array(5) {
  'error_code' => int(1000)
  'status_code' => int(400)
  'data' => NULL
  'message' => string(29) 'User not found'
  'error_messages' => NULL
}
```

This should allow a consistent api returns without the need for try catch. Any standard php exception will fatal the
application like normal.

## testing

To run all tests run `./tests/run.sh`.

This will execute:

 - phpstan level 8
 - phpunit with code coverage (expects 100% coverage)

## license

MIT
