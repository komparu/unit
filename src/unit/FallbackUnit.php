<?php

namespace Komparu\Unit\Unit;

use Komparu\Unit\Unit\UnitInterface;

class FallbackUnit implements UnitInterface
{
    protected $value;
    protected $unit;
    
    public function __construct($value, $unit)
    {
        $this->value    = $value;
        $this->unit     = $unit;
    }
    
    public function all()
    {
        return ['raw' => $this->raw(), 'value' => $this->value()];
    }

    public function getFields()
    {
        return ['raw', 'value'];
    }

    public function raw()
    {
        return $this->value;
    }

    public function value()
    {
        return $this->value . ' ' . $this->unit;
    }
    
    public function jsFormatter()
    {
        return '{0} ' . $this->unit;
    }

}