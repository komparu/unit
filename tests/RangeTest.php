<?php

use Komparu\Value\Range;

class RangeTest extends PHPUnit_Framework_TestCase
{
    public function testMinMax()
    {
        $range = new Range(1, 2);

        $this->assertSame(1, $range->min());
        $this->assertSame(2, $range->max());
    }
}