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
            return $this->returnBoolObject(true);
        } else {
            return $this->returnBoolObject(false);
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
                return $this->returnBoolObject(true);
            } else {
                return $this->returnBoolObject(false);
            }
        } else {
            return $this->returnBoolObject(false);
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

    protected function returnBoolObject($value){
        $bool_factory = new BooleanCreator();
        return $bool_factory->create($value);
    }

    protected  function throwException($message){
        throw new Exception($message);
    }
}
