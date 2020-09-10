# sequence

A Laravel Pipeline package to sequence a request/response flow.

## installation

## usage

### RequestPayload
Create a request payload that will be processed thru the pipeline.
```
class SampleRequestPayload extends AbstractRequestPayload
{
    protected string $name = null;
    
    public function setName(?string $name)
    {
        $this->setName = name;
        return $this;
    }

    public function getName(): ?string
    {
        return $name;
    }
}
```

### ResponsePayload
Create a response payload that will be returned from the pipeline. The final json response will mirror the structure
of the response payload.
```
class SampleResponsePayload extends AbstractResponsePayload
{
        protected string $name = null;
        
        public function construct(SampleRequestPayload $payload)
        {
            $this->setName("Hi my name is: " . $payload->getName());
        }

        public function setName(?string $name)
        {
            $this->setName = name;
            return $this;
        }
    
        public function getName(): ?string
        {
            return $name;
        }
}
```

### Pipeline
Each pipeline can contain groups of pipelines, these are defined as anonymous functions in an array. The key name of
the pipeline will be passed to process below to execute.
```
class SamplePipeline extends AbstractPipeline
{
    public function __construct()
    {
        public const PIPELINE_SAMPLE = 'PipelineSample';

        $this->pipelines = [
            self::PIPELINE_SAMPLE => static function () {
                return (new Pipeline)
                    ->pipe(new MutateName()
                    ->pipe(HydrateResponsePayloadProcess(SampleResponse::class);
            }
        ];
    }
}
```

### Controller
In the controller we will create the RequestPayload from the post data, then instantiate our pipeline. The responseJson()
method will convert the ResponsePayload to json and close the request.
```
public function create(Request $request)
{
    $payload = (new SampleRequestPayload())->hydratePost($request->post());
    $pipeline = new SamplePipline();

    return $pipeline->process(SamplePipeline::PIPELINE_SAMPLE, $payload)->responseJson();
}
```

## testing
