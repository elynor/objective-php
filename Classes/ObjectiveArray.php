<?php

/*
 * Hate it, but i need to extend only 1 object. So I will create all of the Object methods. Hate it T_T
 */
class ObjectiveArray extends ArrayObject
{

    public function __construct()
    {
        if (func_num_args() == 1) {
            $first_argument = func_get_arg(0);
            if (is_array($first_argument)) {
                parent::__construct($first_argument);
            } else {
                $arguments = func_get_args();
                parent::__construct($arguments);
            }
        }
        if (func_num_args() > 1) {
            $arguments = func_get_args();
            parent::__construct($arguments);
        }
        if (func_num_args() == 0) {
            parent::__construct();
        }
    }


    /*
     * Takes block and do the operations in it to every item in array
     */
    public function map($block)
    {

        $func_reflection = new ReflectionFunction($block);
        $num_of_params = $func_reflection->getNumberOfParameters();

        for ($counter = 0; $counter < $this->length()->getValue(); $counter++) {
            if ($num_of_params == 1) {
                $this[$counter] = $block($this[$counter]);
            }
        }

        return $this;
    }

    /*
     * Calculates the length of an object array
     */
    public function length()
    {
        $count = 0;
        foreach ($this as $element) {
            $count++;
        }
        return $this->returnInteger($count);
    }


     /*
     * Object methods.
     * Need to copypaste them because of multiple inheritance -_-
     */

    public function isEmpty()
    {
        if (empty($this) ||
            $this === false
        ) {
            return true;
        } else {
            return false;
        }
    }


    protected function throwException($message)
    {
        throw new Exception($message);
    }

    protected function returnInteger($value)
    {
        return IntegerCreator::create($value);
    }

    protected function returnString($value)
    {
        return StringCreator::create($value);
    }

    protected function returnArray($value)
    {
        return ArrayCreator::create($value);
    }

    protected function returnSelf($modified_value)
    {
        $this->value = new ArrayObject($modified_value);
        return $this;
    }

    /*
     * End of Object methods
     */

}