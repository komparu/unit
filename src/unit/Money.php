<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Komparu\Unit\Unit;

use Komparu\Unit\UnitOfMeasure;

class Money extends Quantity
{
    protected $fields = ['html'];
    
    public function __construct($value, $unit = '&euro;')
    {   
        $si = UnitOfMeasure::nativeUnitFactory('&euro;');  
        $si->addAlias('euro');
        $this->register($si);

        parent::__construct($value, $unit);
    }
    
    public function render($unit)
    {
        $unit = $this->findUnitByName($unit);
        return $unit->getName() . ' ' . number_format($this->to($unit->getName()), 2, ',' , '.');
    }
    
    public function html()
    {
        $unit = $this->neatValue();
        $unit = $this->findUnitByName($unit);
        
        $number = number_format($this->to($unit->getName()), 2, ',' , '.');
        
        $elements = explode(',', $number);
        
        return '<span class="unit">' . $unit->getName() . '</span>' . $elements[0] . '<span class="cents">' . $elements[1] . '</span>';
    }
    
}