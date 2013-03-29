<?php

/*
 * Hate it, but i need to extend only 1 object. So I will create all of the Object methods. Hate it T_T
 */

define(ERROR_WRONG_NUMBER_OF_ARGUMENTS, "Number of arguments is not correct");
define(ERROR_NOT_BOOL, "Return value of lambda is not boolean!");

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
     * Returns a copy of an array with all the null values removed
     */
    public function compact(){
        $new_array = array();
        foreach($this as $element){
            if(!empty($element)){
                array_push($new_array, $element);
            }
        }
        return $this->returnSelf($new_array);
    }

    /*
     * Calculates the length of an object array
     */
    public function length()
    {
        $count = $this->count();
        return $this->returnInteger($count);
    }

    /*
     * Takes block and do the operations in it to every item in array
     */
    public function map($block)
    {

        $func_reflection = new ReflectionFunction($block);
        $num_of_params = $func_reflection->getNumberOfParameters();
        if ($num_of_params == 1) {
            for ($counter = 0; $counter < $this->length()->getValue(); $counter++) {
                $this[$counter] = $block($this[$counter]);
            }
        } else {
            $this->throwException(ERROR_WRONG_NUMBER_OF_ARGUMENTS);
        }

        return $this;
    }

    /*
     * In this case block should return boolean - true or false
     */
    public function select($block, $select_except = false)
    {
        $func_reflection = new ReflectionFunction($block);
        $num_of_params = $func_reflection->getNumberOfParameters();
        $new_array = array();

        if ($num_of_params == 1) {
            foreach ($this as $element) {
                $result = $block($element);
                if (is_bool($result)) {
                    if ($result && !$select_except) {
                        array_push($new_array, $element);
                    }
                    if(!$result && $select_except){
                        array_push($new_array, $element);
                    }
                } else {
                    $this->throwException(ERROR_NOT_BOOL);
                }
            }
        } else {
            $this->throwException(ERROR_WRONG_NUMBER_OF_ARGUMENTS);
        }

        return $this->returnArray($new_array);
    }




    /*
    * Object methods.
    * Need to copypaste them because of multiple inheritance -_-
    */

    public function isEmpty()
    {
        if (empty($this) ||
            $this === false ||
            //Well yeah. Pretty heavy operation, but PHP have no method "length" for an ArrayObject...
            $this->length()->getValue() == 0
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
        $this->exchangeArray($modified_value);
        return $this;
    }

    /*
     * End of Object methods
     */

}