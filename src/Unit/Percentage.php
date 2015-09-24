<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Komparu\Unit\Unit;

use Komparu\Unit\UnitOfMeasure;

class Percentage extends Quantity
{
    public function __construct($value, $unit = 'percentage', array $translation = [])
    {   
        $si = UnitOfMeasure::nativeUnitFactory('percentage');  
        $si->addAlias('%');
        $this->register($si);

        parent::__construct($value, $unit);
    }
    
    public function render($unit)
    {
        $unit = $this->findUnitByName($unit);
        return number_format($this->to($unit->getName()), 0, ',' , '.') . '%';
    }
    
}
