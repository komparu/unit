<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Komparu\Unit\Unit;

use Komparu\Unit\UnitOfMeasure;

class Time extends Quantity
{
    use TimeUnitTrait;
    
    public function __construct($value, $unit = 's')
    {        
        $si = UnitOfMeasure::nativeUnitFactory('s');        
        $this->register($si);
        
        $this->addMissingPrefixedUnits($si, 1, '%p');

        parent::__construct($value, $unit);
    }
}