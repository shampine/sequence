<?php
declare(strict_types=1);

namespace Shampine\Sequence\Process;

use RuntimeException;
use Shampine\Sequence\Entity\ChildPipelineEntity;
use Shampine\Sequence\Exceptions\SequenceException;
use Shampine\Sequence\Exceptions\ValidationException;
use Shampine\Sequence\Payload\ChildPipelineInterface;
use Shampine\Sequence\Response\ErrorResponseWrapper;

class ChildPipelineProcess extends AbstractProcess
{
    /**
     * @param ChildPipelineInterface $payload
     * @return ChildPipelineInterface
     * @throws RuntimeException
     * @throws SequenceException
     * @throws ValidationException
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
                $entity->getPayload(),
                ...$entity->getArguments()
            );

            if ($pipeline->getResponse() instanceof ErrorResponseWrapper) {
                if ($entity->getSuppressErrors() === true) {
                    continue;
                }

                $exception = new SequenceException();

                if ($pipeline->getResponse()->getErrorMessages() !== null) {
                    $exception = new ValidationException();
                    $exception->setErrorMessages($pipeline->getResponse()->getErrorMessages());
                }

                if ($pipeline->getResponse()->getErrorCode() !== null) {
                    $exception->setErrorCode($pipeline->getResponse()->getErrorCode());
                }

                if ($pipeline->getResponse()->getStatusCode() !== null) {
                    $exception->setHttpCode($pipeline->getResponse()->getStatusCode());
                }

                if ($pipeline->getResponse()->getMessage() !== null) {
                    $exception->setErrorMessage($pipeline->getResponse()->getMessage());
                }

                throw $exception;
            }

            if ($entity->getCallback() !== null) {
                $payload = $entity->getCallback()($payload, $pipeline->getResponse());
            }
        }

        return $payload;
    }
}
