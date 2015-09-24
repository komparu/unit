<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Komparu\Unit\Unit;

use Komparu\Unit\UnitOfMeasure;
use Komparu\Unit\Traits\SIUnitTrait;

class Mass extends Quantity
{
    use SIUnitTrait;
    
    public function __construct($value, $unit = 'g', array $translation = [])
    {        
        $si = UnitOfMeasure::nativeUnitFactory('g');        
        $this->register($si);
        
        $this->addMissingPrefixedUnits($si, 1, '%pg');

        parent::__construct($value, $unit);
    }
    
}
