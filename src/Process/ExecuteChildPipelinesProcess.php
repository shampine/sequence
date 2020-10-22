<?php
declare(strict_types=1);

namespace Shampine\Sequence\Process;

use RuntimeException;
use Shampine\Sequence\Entity\ChildPipelineEntity;
use Shampine\Sequence\Exceptions\SequenceException;
use Shampine\Sequence\Payload\ChildPipelineInterface;
use Shampine\Sequence\Response\ErrorResponseWrapper;

class ExecuteChildPipelinesProcess extends AbstractProcess
{
    /**
     * @param ChildPipelineInterface $payload
     * @return ChildPipelineInterface
     * @throws RuntimeException
     * @throws SequenceException
     */
    public function process($payload): ChildPipelineInterface
    {
        if (!$payload instanceof ChildPipelineInterface) {
            throw new RuntimeException('Payload is not an instance of ChildPipelineInterface');
        }

        $entities = $payload->getChildPipelineEntities();

        /** @var ChildPipelineEntity $entity */
        foreach ($entities as &$entity) {
            $pipeline = $entity->getPipelineClass()->process(
                $entity->getPipelineName(),
                $entity->getPayload()
            );

            if ($pipeline->getResponse() instanceof ErrorResponseWrapper) {
                if ($entity->getSuppressErrors() === true) {
                    continue;
                }

                throw new SequenceException(
                    $pipeline->getResponse()->getErrorCode(),
                    $pipeline->getResponse()->getMessage(),
                    $pipeline->getResponse()->getStatusCode()
                );
            }

            if ($entity->getCallback() !== null) {
                $payload = $entity->getCallback()($payload, $pipeline->getResponse());
            }
        }

        return $payload;
    }
}
