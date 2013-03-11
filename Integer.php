<?php
/**
 * User: michael
 * Date: 2/18/13
 * Time: 2:13 PM
 */
require_once("Object.php");

class Integer extends Object
{
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function even()
    {
        if($this->value % 2 == 0){
            return $this->returnBoolean(true);
        } else {
            return $this->returnBoolean(false);
        }
    }

    public function odd()
    {
        if($this->value % 2 != 0){
            return $this->returnBoolean(true);
        } else {
            return $this->returnBoolean(false);
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