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

    protected $prefixes = [
        [
            'name' => 'year',
            'factor'      => 31536000
        ],
        [
            'name' => 'month',
            'factor'      => 2628000
        ],
        [
            'name' => 'day',
            'factor'      => 86400
        ],
        [
            'name' => 'hour',
            'factor'      => 3600
        ],
        [
            'name' => 'minute',
            'factor'      => 60
        ],
        [
            'name' => 'seconds',
            'factor'      => 1
        ]
    ];
    
    public function __construct($value, $unit = 's', array $translation = [])
    {        
        $si = UnitOfMeasure::nativeUnitFactory('seconds');  
        $this->register($si);
        
        $this->addMissingPrefixedUnits($si, 1);

        parent::__construct($value, $unit, $translation);
    }
    
    protected function addMissingPrefixedUnits(UnitOfMeasure $si, $toBaseSi)
    {
        $noPrefix = $si->convertToNative(1) * $toBaseSi;
        
        foreach ($this->prefixes as $prefix) {
            
            $toNative = $noPrefix * $prefix['factor'];
            
            $newUnit = UnitOfMeasure::linearUnitFactory($prefix['name'], $toNative);
            
            $this->register($newUnit);
        }
    }
}