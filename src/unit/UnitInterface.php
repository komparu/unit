<?php

namespace Komparu\Unit\Unit;

interface UnitInterface
{
    public function __construct($value, $unit, array $translation = []);
    
    public function getFields();
    
    public function all();
    
    public function value();
    
    public function raw();
    
    public function jsFormatter();
}