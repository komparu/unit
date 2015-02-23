<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Komparu\Unit\Unit;

use Komparu\Unit\UnitOfMeasure;

class Bitrate extends Quantity
{
    use ByteUnitsTrait;
    
    public function __construct($value, $unit = 'kbit/s')
    {        
        $si = UnitOfMeasure::nativeUnitFactory('bit/s');        
        $this->register($si);
        
        $this->addMissingPrefixedUnits($si, 1, '%pbit/s');

        parent::__construct($value, $unit);
    }
}