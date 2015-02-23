<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Komparu\Unit;

class UnitOfMeasure
{
    
    protected $name;
    protected $fromNative;
    protected $toNative;
    
    protected $aliases = [];
    
    public static function linearUnitFactory($name, $toNativeUnitFactor)
    {
        return new static(
                $name,
                function ($value) use ($toNativeUnitFactor) {
                    return $value / $toNativeUnitFactor;
                },
                function ($value) use ($toNativeUnitFactor) {
                    return $value * $toNativeUnitFactor;
                });
    }
    
    public static function nativeUnitFactory($name)
    {
        return static::linearUnitFactory($name, 1);
    }
    
    public function __construct($name, callable $from, callable $to)
    {
        $this->name         = $name;
        $this->fromNative   = $from;
        $this->toNative     = $to;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function addAlias($alias)
    {
        $this->aliases[] = $alias;
    }
    
    public function isAliasOf($unit)
    {
        return in_array($unit, $this->aliases);
    }
    
    public function getAliases()
    {
        return $this->aliases;
    }
    
    public function convertFromNative($value)
    {
        $callable = $this->fromNative;
        return $callable($value);
    }
    
    public function convertToNative($value)
    {
        $callable = $this->toNative;
        return $callable($value);
    }
}