<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Komparu\Unit\Traits;

use Komparu\Unit\UnitOfMeasure;

trait SIUnitTrait
{
    protected $prefixes = [
        [
            'abbr_prefix' => 'Y',
            'long_prefix' => 'yotta',
            'factor'      => 1e24
        ],
        [
            'abbr_prefix' => 'Z',
            'long_prefix' => 'zetta',
            'factor'      => 1e21
        ],
        [
            'abbr_prefix' => 'E',
            'long_prefix' => 'exa',
            'factor'      => 1e18
        ],
        [
            'abbr_prefix' => 'P',
            'long_prefix' => 'peta',
            'factor'      => 1e15
        ],
        [
            'abbr_prefix' => 'T',
            'long_prefix' => 'tera',
            'factor'      => 1e12
        ],
        [
            'abbr_prefix' => 'G',
            'long_prefix' => 'giga',
            'factor'      => 1e9
        ],
        [
            'abbr_prefix' => 'M',
            'long_prefix' => 'mega',
            'factor'      => 1e6
        ],
        [
            'abbr_prefix' => 'k',
            'long_prefix' => 'kilo',
            'factor'      => 1e3
        ],
        [
            'abbr_prefix' => 'h',
            'long_prefix' => 'hecto',
            'factor'      => 1e2
        ],
        [
            'abbr_prefix' => 'da',
            'long_prefix' => 'deca',
            'factor'      => 1e1
        ],
        [
            'abbr_prefix' => '',
            'long_prefix' => '',
            'factor'      => 1
        ],
        [
            'abbr_prefix' => 'd',
            'long_prefix' => 'deci',
            'factor'      => 1e-1
        ],
        [
            'abbr_prefix' => 'c',
            'long_prefix' => 'centi',
            'factor'      => 1e-2
        ],
        [
            'abbr_prefix' => 'm',
            'long_prefix' => 'milli',
            'factor'      => 1e-3
        ],
        [
            'abbr_prefix' => 'µ',
            'long_prefix' => 'micro',
            'factor'      => 1e-6
        ],
        [
            'abbr_prefix' => 'n',
            'long_prefix' => 'nano',
            'factor'      => 1e-9
        ],
        [
            'abbr_prefix' => 'p',
            'long_prefix' => 'pico',
            'factor'      => 1e-12
        ],
        [
            'abbr_prefix' => 'f',
            'long_prefix' => 'femto',
            'factor'      => 1e-15
        ],
        [
            'abbr_prefix' => 'a',
            'long_prefix' => 'atto',
            'factor'      => 1e-18
        ],
        [
            'abbr_prefix' => 'z',
            'long_prefix' => 'zepto',
            'factor'      => 1e-21
        ],
        [
            'abbr_prefix' => 'y',
            'long_prefix' => 'yocto',
            'factor'      => 1e-24
        ],
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
