<?php

use Komparu\Value\ValueFactory;
use Komparu\Value\Partial;
use Komparu\Value\Range;
use Komparu\Value\Operator;

class ValueFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideOperator
     * @param $expectedClass
     * @param $expectedConversion
     * @param $expectedOperator
     */
    public function testStringToOperator($value, $expectedClass, $expectedConversion, $expectedOperator)
    {
        $operator = ValueFactory::fromString($value);
        $this->assertInstanceOf($expectedClass, $operator);
        $this->assertSame($expectedConversion, $operator->value());
        $this->assertSame($expectedOperator, $operator->operator());
    }

    public function provideOperator()
    {
        return [
            ['test', Operator::class, 'test', '='],
            ['20', Operator::class, 20, '='],
            ['20.3', Operator::class, 20.3, '='],
            ['>20', Operator::class, 20, '>'],
            ['>=20', Operator::class, 20, '>='],
            ['<20', Operator::class, 20, '<'],
            ['<=20', Operator::class, 20, '<='],
        ];
    }

    /**
     * @dataProvider provideRange
     * @param $expectedClass
     * @param $expectedConversion
     */
    public function testStringToRange($value, $expectedClass, $min, $max)
    {
        $range = ValueFactory::fromString($value);
        $this->assertInstanceOf($expectedClass, $range);
        $this->assertSame($min, $range->min());
        $this->assertSame($max, $range->max());
    }

    public function provideRange()
    {
        return [
            ['20~40', Range::class, 20, 40],
        ];
    }

    /**
     * @dataProvider providePartial
     * @param $expectedClass
     * @param $expectedConversion
     */
    public function testStringToPartial($value, $expectedClass, $expectedConversion, $left, $right)
    {
        $partial = ValueFactory::fromString($value);
        $this->assertInstanceOf($expectedClass, $partial);
        $this->assertSame($expectedConversion, $partial->value());
        $this->assertSame($left, $partial->left());
        $this->assertSame($right, $partial->right());
    }

    public function providePartial()
    {
        return [
            ['~zzz~', Partial::class, 'zzz', true, true],
            ['zzz~', Partial::class, 'zzz',  false, true],
            ['~zzz', Partial::class, 'zzz', true, false],
        ];
    }

    /**
     * @dataProvider provideTypecast
     * @param $raw
     * @param $type
     */
    public function testTypecast($raw, $type, $result)
    {
        $value = ValueFactory::typecast($raw, $type);
        $this->assertSame($result, $value);
    }

    public function provideTypecast()
    {
        return [
            ['test', 'bool', true],
            ['', 'bool', false],
            ['false', 'bool', false],
            ['true', 'bool', true],
            [1, 'bool', true],
            [0, 'bool', false],
            ['123', 'int', 123],
            ['123.45', 'decimal', '123.45'],
            ['123.45', 'float', 123.45],
            ['{"foo":"bar"}', 'array', ['foo' => 'bar']],
        ];
    }
}