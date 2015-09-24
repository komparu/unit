<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Komparu\Unit\Traits;

use Komparu\Unit\UnitOfMeasure;

trait TimeUnitTrait
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
    
    protected function addMissingPrefixedUnits(UnitOfMeasure $si, $toBaseSi, $namePattern, array $aliasPatterns = [])
    {
        $noPrefix = $si->convertToNative(1) * $toBaseSi;
        $units = $this->getSupportedUnits(true);
        
        foreach ($this->prefixes as $prefix) {
            
            $parsePattern = function($pattern) use ($prefix) {
                return strtr($pattern, [
                        '%p' => $prefix['abbr_prefix'],
                        '%P' => $prefix['long_prefix']
                    ]);
            };
            
            $name = $parsePattern($namePattern);
            if (in_array($name, $units)) {
                continue;
            }
            
            $toNative = $noPrefix * $prefix['factor'];
            
            $newUnit = UnitOfMeasure::linearUnitFactory($name, $toNative);
            
            foreach ($aliasPatterns as $aliasPattern) {
                $newUnitAlias = $parsePattern($aliasPattern);
                if (in_array($newUnitAlias, $units)) {
                    continue 2;
                }
                $newUnit->addAlias($newUnitAlias);
            }
            
            $this->register($newUnit);
        }
    }
}
