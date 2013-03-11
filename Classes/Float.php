<?php
/**
 * User: michael
 * Date: 3/11/13
 * Time: 5:11 PM
 */
class Float extends Object
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
