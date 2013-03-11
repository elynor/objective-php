<?php


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
}
