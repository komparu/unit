<?php

namespace Komparu\Unit\Unit;

interface UnitInterface
{
    public function __construct($value, $unit, array $translation = []);
    
    public function getFields();

    public function fancy();
    
    public function all();
    
    public function value();
    
    public function raw();
}