# unit
Helper for handling units of measure

### Supported units
* Bitrate (bit/s)
* ElectricCurrent (A)
* Length (m)
* LuminousIntensity (cd)
* Mass (g)
* Money (euro)
* Percentage (%)
* Time

### Convert
```php
$value = UnitFactory::build(1, 'km');
$value->to('m');    // return 1000
```

### Print
```php
$value = UnitFactory::build(1000, 'kb');
$value->fancy(); // returns (string) '1 Mb'
$value->to('Gb'); // returns (float) 0.001

$value = UnitFactory::build(1, 'kg');
$value->to(); // returns (float) 1000
```
