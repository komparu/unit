<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Komparu\Unit\Unit;

use Komparu\Unit\UnitOfMeasure;

abstract class Quantity
{
    protected $value;
    protected $unit;
    protected $unitDefinitions = [];
    
    protected $significance = false;
    
    public function __construct($value, $unit)
    {
        $this->value = $value;
        $this->unit = $unit;
    }
    
    public function __toString()
    {
        return $this->get();
    }
    
    public function raw()
    {
        return $this->value;
    }
    
    public function render($unit)
    {
        $unit = $this->findUnitByName($unit);
        return $this->to($unit->getName()) . ' ' . $unit->getName();
    }
    
    public function getSupportedUnits($withAliases = false)
    {
        $units = [];
        foreach ($this->unitDefinitions as $unitOfMeasure) {
            $units[] = $unitOfMeasure->getName();
            if ($withAliases) {
                foreach ($unitOfMeasure->getAliases() as $alias) {
                    $units[] = $alias;
                }
            }
        }

        return $units;
    }
    
    public function register(UnitOfMeasure $unit)
    {
        $this->unitDefinitions[] = $unit;
    }
    
    public function to($unit = false)
    {
        $original   = $this->findUnitByName($this->unit);
        $value      = $original->convertToNative($this->value);
        
        if ($unit === false) {
            $to         = $this->findUnitByName($unit);
            $value      = $to->convertFromNative($value);
        }

        return $value;
    }
    
    protected function findUnitByName($unit)
    {
        foreach($this->unitDefinitions as $unitOfMeasure) {
            if($unit === $unitOfMeasure->getName() || $unitOfMeasure->isAliasOf($unit)) {
                return $unitOfMeasure;
            }
        }
        
        throw new \Exception("Unknown unit ($unit)");
    }
    
    public function get()
    {
        $original   = $this->findUnitByName($this->unit);
        $value      = $original->convertToNative($this->value);
        $evalue     = false;

        foreach ($this->unitDefinitions as $unitOfMeasure) {
            
            $tvalue = $unitOfMeasure->convertFromNative($value);
            
            if (!$evalue || ( $tvalue < $evalue && $tvalue >= 1 ) ) {
                $evalue = $tvalue;
                $unit = $unitOfMeasure->getName();
            }
        }
        
        return $this->render($unit);
    }
}