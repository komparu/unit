<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Komparu\Unit;

class UnitFactory
{
    static $self = null;
    
    static $aliases = [];
    
    public function __construct()
    {
        $units = [
            '\Komparu\Unit\Unit\Bitrate',
            '\Komparu\Unit\Unit\Money',
            '\Komparu\Unit\Unit\Percentage',
            '\Komparu\Unit\Unit\Length',
            '\Komparu\Unit\Unit\Time',
            '\Komparu\Unit\Unit\Mass',
            '\Komparu\Unit\Unit\ElectricCurrent',
            '\Komparu\Unit\Unit\LuminousIntensity',
            '\Komparu\Unit\Unit\DigitalInformation',
        ];
        
        foreach ($units as $unit) {
            $unitClass = $this->getClass($unit, [1, null]);
            $support = $unitClass->getSupportedUnits(true);
            self::$aliases[$unit] = $support;
        }
    }
    
    /**
     * 
     * @param type $value
     * @param type $unit
     * @return type
     * @throws \Symfony\Component\Debug\Exception\ClassNotFoundException
     */
    public function build($value, $unit)
    {
        $className = $this->has($unit);
        if ($className) {
            return $this->getClass($className, [$value, $unit]);
        } else {
            throw new \Symfony\Component\Debug\Exception\ClassNotFoundException('unit class ' . $unit . ' not found', new \ErrorException());
        }
    }
    
    /**
     * 
     * @param type $unit
     * @return type
     */
    public function has($unit)
    {
        foreach(self::$aliases as $key => $alias)
        {
            if(in_array($unit, $alias)) {
                return $key;
            }
        }
        
        return false;
    }
    
    public function all()
    {
        return self::$aliases;
    }
    
    /**
     * 
     * @param type $className
     * @param type $args
     * @return type
     */
    protected function getClass($className, $args)
    {
        $class = new \ReflectionClass($className);
        return $class->newInstanceArgs($args);
    }
}