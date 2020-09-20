<?php
declare(strict_types=1);

namespace Shampine\Sequence\Process;

class HydrateResponseProcess extends AbstractProcess
{
    /**
     * @var string
     */
    protected string $responseClass;

    /**
     * @param string $responseClass
     */
    public function __construct(string $responseClass)
    {
        $this->responseClass = $responseClass;
    }

    /**
     * @param mixed $payload
     * @return mixed
     */
    public function process($payload)
    {
        return new $this->responseClass($payload);
    }
}
