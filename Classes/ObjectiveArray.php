<?php
define(ERROR_WRONG_NUMBER_OF_ARGUMENTS, "Number of arguments is not correct");
define(ERROR_NOT_BOOL, "Return value of lambda is not boolean!");
define(ERROR_NOT_SINGLE_ELEMENT, "This array has more than 1 element");
define(ERROR_NOT_A_STRING, "This is not a string");

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
     * @Override
     * Appends element to array. Override parent method just for usability
     */
    public function append($element){
        parent::append($element);
    }


    /*
     * Returns a copy of an array with all the null values removed
     */
    public function compact()
    {
        $new_array = array();
        foreach ($this as $element) {
            if (!empty($element)) {
                array_push($new_array, $element);
            }
        }
        return $this->returnSelf($new_array);
    }

    /*
     * Delete all of the presence of element in array
     */
    public function delete($element)
    {
        $element_positions = $this->findElement($element);
        foreach($element_positions as $position){
            $this[$position] = null;
        }
        return $this;
    }


    /*
     * Returns an array with all element's positions
     */
    public function findElement($element)
    {
        $results_array = array();
        $array_element = "";
        $comparable_element = "";
        for ($i = 0; $i < count($this); $i++) {
            //If array has objects, that could be threaten as an Object, let's do this.

            $type = gettype($this[$i]);
            if($type == "string"    ||
                $type == "integer"  ||
                $type == "double"   ||
                $type == "array"    ||
                $type == "NULL"){
                $array_element = $this[$i];
            } else {
                $array_element = $this[$i]->getValue();
            }
            // Check for inputted element. If it is an object, lets get it's value
            $type = gettype($element);
            if($type == "string"    ||
                $type == "integer"  ||
                $type == "double"   ||
                $type == "array"    ||
                $type == "NULL"){

                $comparable_element = $element;
            } else {
                $comparable_element = $element->getValue();
            }

            if ($array_element === $comparable_element) {
                array_push($results_array, $i);
            }
        }
        return $this->returnArray($results_array);
    }


    /*
     * Just a wrapper on ArrayObject's
     */
    public function keySort(){
        $this->ksort();
        return $this;
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
     * If current array contains only 1 element, it would create a string which represents that value if it would be php
     * basic type , it would create a string with this value. Otherwise, it would lust return an object.
     */
    public function minimize()
    {
        if ($this->length()->getValue() == 1) {
            $type = gettype($this[0]);
            if($type == "string"    ||
                $type == "integer"  ||
                $type == "double"   ||
                $type == "array"    ||
                $type == "NULL"){

                return $this->returnString($this[0]);
            } else {
                return $this[0];
            }
        } else {
            $this->throwException(ERROR_NOT_SINGLE_ELEMENT);
        }
    }


    /*
     * Just a wrapper on Array Object' s natsort()
     */
    public function naturalSort(){
        $this->natsort();
        return $this;
    }

    /*
     * Only for arrays, not hashes
     */
    public function reverse(){
        $length = $this->count()-1;
        $half = $this->count()/2;

        for($counter = 0; $counter < $half; $counter++){
            $temp = $this[$length-$counter];
            $this[$length-$counter] = $this[$counter];
            $this[$counter] = $temp;
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
                    if (!$result && $select_except) {
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
     * String representation of array
     */
    public function serialize(){
        return $this->returnString(parent::serialize());
    }

    /*
     * Restoring data from text string
     */
    public function unserialize($string){
        if(is_string($string)){
            $serialized_str = $string;
        } else {
            if(get_class($string) == "String"){
                $serialized_str = $string->getValue();
            } else {
                $this->throwException(ERROR_NOT_A_STRING);
            }
        }

        parent::unserialize($serialized_str);
    }

    /*
     * Just renamed method asort() from ArrayObject. Sorts by values in array
     */
    public function valueSort(){
        $this->asort();
        return $this;
    }
    /*
    * Object methods.
    * Need to copypaste them because of multiple inheritance -_-
    */

    public function isEmpty()
    {
        if (empty($this) ||
            $this === false ||
            $this->length()->getValue() == 0
        ) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Clone current array
     */
    public function getClone(){
        return $this->returnArray($this);
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