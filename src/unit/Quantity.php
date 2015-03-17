<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Komparu\Unit\Unit;

use Komparu\Unit\UnitOfMeasure;

abstract class Quantity implements UnitInterface
{
    protected $value;
    protected $unit;
    protected $unitDefinitions = [];
    
    protected $significance = false;
    protected $fields = [];
    
    public function __construct($value, $unit)
    {
        $this->value = $value;
        $this->unit = $unit;
    }
    
    public function __toString()
    {
        return $this->value();
    }
    
    public function getFields()
    {
        return array_merge($this->fields, ['raw', 'value']);
    }
    
    public function all()
    {
        $fields = $this->getFields();
        
        foreach ($fields as $field) {
            $result[$field] = $this->$field();
        }
        
        return $result;
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
    
    public function jsFormatter()
    {
        return '{0} ' . $this->unit;
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
        
        if ($unit !== false) {
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
    
    protected function neatValue()
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
        
        return $unit;
    }
    
    public function value()
    {
        $unit = $this->neatValue();
        return $this->render($unit);
    }
}