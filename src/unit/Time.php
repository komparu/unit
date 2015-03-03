<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Komparu\Unit\Unit;

class Time extends Quantity
{

    protected $prefixes = [
        [
            'abbr_prefix' => 'Y',
            'long_prefix' => 'year',
            'factor'      => 3153600
        ],
        [
            'abbr_prefix' => 'm',
            'long_prefix' => 'month',
            'factor'      => 2628000
        ],
        [
            'abbr_prefix' => 'd',
            'long_prefix' => 'day',
            'factor'      => 86400
        ],
        [
            'abbr_prefix' => 'h',
            'long_prefix' => 'hour',
            'factor'      => 3600
        ],
        [
            'abbr_prefix' => 'i',
            'long_prefix' => 'minute',
            'factor'      => 60
        ],
        [
            'abbr_prefix' => 's',
            'long_prefix' => 'seconds',
            'factor'      => 1
        ]
    ];
    
    public function __construct($value, $unit = 's')
    {        
        $si = UnitOfMeasure::nativeUnitFactory('s');  
        $si->addAlias('second');
        $this->register($si);
        
        $this->addMissingPrefixedUnits($si, 1);

        parent::__construct($value, $unit);
    }
    
    protected function addMissingPrefixedUnits(UnitOfMeasure $si, $toBaseSi)
    {
        $noPrefix = $si->convertToNative(1) * $toBaseSi;
        
        foreach ($this->prefixes as $prefix) {
            
            $toNative = $noPrefix * $prefix['factor'];
            
            $newUnit = UnitOfMeasure::linearUnitFactory($prefix['abbr_prefix'], $toNative);
            $newUnit->addAlias($prefix['long_prefix']);
            
            $this->register($newUnit);
        }
    }
}