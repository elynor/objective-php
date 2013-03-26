<?php

include "InterfaceIncluder.php";
include "ObjectCreator/ObjectCreator.php";
/**
 * User: michael
 * Date: 2/15/13
 * Time: 1:36 PM
 */
class Object
{
    protected $value;


    public function __construct($value = "")
    {
        if ($value != "") {
            $this->value = $value;
        }

    }


    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function isEmpty()
    {
        if (empty($this->value) ||
            $this->value === "" ||
            $this->value === false
        ) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Note! Two object instances are equal if they have the same attributes and values, and are instances of the same class.
     */
    public function equals($other_class)
    {
        $bool_factory = new BooleanCreator();
        if (method_exists($other_class, "getValue")) {
            if ($this->getValue() === $other_class->getValue()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function getHashCode()
    {
        return spl_object_hash($this);
    }

    public function getClass()
    {
        return get_class($this);
    }

    public function getClone()
    {
        $cloned_object = new self($this->value);
        return $cloned_object;
    }

    public function __toString(){
        return (string)$this->value;
    }

    protected  function throwException($message){
        throw new Exception($message);
    }

    protected function returnInteger($value){
        return IntegerCreator::create($value);
    }

    protected function returnString($value){
        return StringCreator::create($value);
    }

    protected function returnFloat($value){
        return FloatCreator::create($value);
    }

    protected function returnArray($value){
        return ArrayCreator::create($value);
    }

    protected function returnSelf($modified_value){
        $this->value = $modified_value;
        return $this;
    }


}
