<?php
declare(strict_types=1);

namespace Support;

use PHPUnit\Framework\TestCase;
use Shampine\Sequence\Support\Str;

class StrTest extends TestCase
{
    /**
     * @return void
     */
    public function testSnakeCase(): void
    {
        self::assertEquals('test_snake', Str::snakeCase('testSnake'));
        self::assertEquals('test_snake', Str::snakeCase('TestSnake'));
    }

    /**
     * @return void
     */
    public function testStudly(): void
    {
        self::assertEquals('TestStudly', Str::studlyCase('test_studly'));
        self::assertEquals('TestStudly', Str::studlyCase('testStudly'));
    }

    public function testGetter():void
    {
        self::assertEquals('getTestGetter', Str::getter('test_getter'));
        self::assertEquals('getTestGetter', Str::getter('testGetter'));
    }

    public function testSetter(): void
    {
        self::assertEquals('setTestSetter', Str::setter('test_setter'));
        self::assertEquals('setTestSetter', Str::setter('testSetter'));
    }
}
