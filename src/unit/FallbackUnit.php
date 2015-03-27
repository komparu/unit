<?php

namespace Komparu\Unit\Unit;

use Komparu\Unit\Unit\UnitInterface;

class FallbackUnit implements UnitInterface
{
    protected $value;
    protected $unit;
    protected $translation;
    
    public function __construct($value, $unit, array $translation = [])
    {
        $this->value        = $value;
        $this->unit         = $unit;
        $this->translation  = $translation;
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
        $unit = isset($this->translation[$this->unit]) ? $this->translation['unit.' . $this->unit] : $this->unit;
        return $this->value . ' ' . $unit;
    }
    
    public function jsFormatter()
    {
        return '{0} ' . $this->unit;
    }

}