<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Komparu\units;

use Komparu\Unit\UnitOfMeasure;

class ElectricCurrent extends Quantity
{
    use SIUnitTrait;
    
    public function __construct($value, $unit = 'A')
    {        
        $si = UnitOfMeasure::nativeUnitFactory('A');        
        $this->register($si);
        
        $this->addMissingPrefixedUnits($si, 1, '%pA');

        parent::__construct($value, $unit);
    }
    
}