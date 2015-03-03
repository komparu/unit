<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Komparu\Unit\Unit;

use Komparu\Unit\UnitOfMeasure;
use Komparu\Unit\Traits\ByteUnitTrait;

class DigitalInformation extends Quantity
{
    use ByteUnitTrait;
    
    public function __construct($value, $unit = 'kbit')
    {        
        $si = UnitOfMeasure::nativeUnitFactory('bit');        
        $this->register($si);
        
        $this->addMissingPrefixedUnits($si, 1, '%pbit');
        $this->addMissingPrefixedUnits($si, 0.125, '%pb'); // byte

        parent::__construct($value, $unit);
    }
}