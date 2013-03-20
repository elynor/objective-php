<?php
/**
 * User: michael
 * Date: 3/11/13
 * Time: 5:11 PM
 */

class Float extends Object implements NumericInterface
{
    public function __construct($value)
    {
        $value = str_replace(",", ".", $value);
        $float_value = floatval($value);
        if($float_value == 0){
            return $this->returnBoolean(false);
        } else {
            return $this->returnObject($float_value);
        }
    }

    public function round($precision = 0){
        $new_value = round($this->value, $precision);
        return $this->returnObject($new_value);
    }

    public function increment()
    {
        $new_value = $this->value + 1;
        return $this->returnObject($new_value);
    }

    public function abs()
    {
        $new_value = abs($this->value);
        return $this->returnObject($new_value);
    }

    private function returnBoolean($boolean)
    {
        return new Boolean($boolean);
    }

    private function returnObject($new_value)
    {
        $this->value = $new_value;
        return $this;
    }

}
