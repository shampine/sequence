<?php
declare(strict_types=1);

namespace Shampine\Tests\Exceptions;

use PHPUnit\Framework\TestCase;
use Shampine\Sequence\Exceptions\SequenceException;
use Shampine\Sequence\Exceptions\ValidationException;

class ExceptionTest extends TestCase
{
    /**
     * @dataProvider exceptionProvider
     * @param string $exceptionClass
     * @return void
     */
    public function testException(string $exceptionClass): void
    {
        $exception = new $exceptionClass;
        $exception->setErrorCode(9999);
        $exception->setHttpCode(200);
        $exception->setErrorMessage('Message');
        $exception->setErrorMessages(['Error' => 'Messages']);

        self::assertEquals(9999, $exception->getErrorCode());
        self::assertEquals(200, $exception->getHttpCode());
        self::assertEquals('Message', $exception->getErrorMessage());
        self::assertEquals(['Error' => 'Messages'], $exception->getErrorMessages());
    }

    /**
     * @return array<array>
     */
    public function exceptionProvider(): array
    {
        return [
            [
                SequenceException::class,
            ],
            [
                ValidationException::class,
            ],
        ];
    }
}
