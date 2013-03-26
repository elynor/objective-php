<?php
/**
 * User: michael
 * Date: 2/15/13
 * Time: 5:11 PM
 */
//require_once("Object.php");
//require_once("Integer.php");

define(ERROR_NOT_A_NUMBER, "This is not a number!");
define(ERROR_INCLUDE, "There is no such substring in this string!");
define(ERROR_OUT_OF_RANGE, "Index is out of range!");
define(ERROR_WRONG_ARGS_COUNT, "Number of arguments is not valid!");
define(ERROR_WRONG_CLASS, "Argument is not String!");



class String extends Object
{
    public function __construct($value)
    {
        return $this->returnSelf($value);
    }


    public function add($other_string)
    {
        try {
            if (is_int($other_string)) {
                $this->value .= strval($other_string);
            } elseif (is_array($other_string)) {
                foreach ($other_string as $key => $value) {
                    $this->value .= $value;
                }
            } else {
                $other_string = $this->checkForObject($other_string);
                $this->value .= $other_string;
            }

            return $this->returnSelf($this->value);

        } catch (Exception $exception) {
            echo $exception;
        }
    }


    public function capitalize()
    {
        $str = $this->value;
        $new_value = strtoupper($this->value[0]) . strtolower(substr($str, 1));
        return $this->returnSelf($new_value);
    }


    public function clear()
    {
        return $this->returnSelf("");
    }

    /*
    * Compare with other string. If this string is bigger then compared, returns 1, if equals, returns 0. If it lesser, then -1
    */
    public function compare($other_string)
    {
        $MORE = 1;
        $EQUALS = 0;
        $LESS = -1;

        $other_string_object = $this->checkForObject($other_string);

        if ($other_string_object->getClass() === "String") {
            if ($this->length()->getValue() > $other_string_object->length()->getValue()) {
                return $this->returnInteger($MORE);
            } elseif ($this->length()->getValue() == $other_string_object->length()->getValue()) {
                return $this->returnInteger($EQUALS);
            } elseif ($this->length()->getValue() < $other_string_object->length()->getValue()) {
                return $this->returnInteger($LESS);
            }
        } else {
            $this->throwException(ERROR_WRONG_CLASS);
        }
    }

    public function count($substring)
    {
        $value = substr_count($this->value, $substring);
        return $this->returnInteger($value);
    }


    public function each($splitter, $block)
    {
        $substrings_array = explode($splitter, $this->value);
        $final_string = new self("");
        $func_reflection = new ReflectionFunction($block);
        $num_of_params = $func_reflection->getNumberOfParameters();

        foreach ($substrings_array as $substring) {
            if ($num_of_params == 1) {
                $substring = $block(new self($substring));
            } elseif ($num_of_params == 0) {
                $block;
                $substring = new self($substring);
            } else {
                $this->throwException(ERROR_WRONG_ARGS_COUNT);
            }
            $final_string->add($substring);
        }
        return $this->returnSelf($final_string);
    }


    public function escape()
    {
        $new_value = addslashes($this->value);
        return $this->returnSelf($new_value);
    }


    public function escapeHtml()
    {
        $new_value = htmlspecialchars($this->value);
        return $this->returnSelf($new_value);
    }

    public function escapeMysql()
    {
        $new_value = mysql_real_escape_string($this->value);
        return $this->returnSelf($new_value);
    }


    public function getChar($char_position, $return_last = true)
    {
        if (is_int($char_position)) {
            if (!empty($this->value[$char_position])) {
                return $this->returnString($this->value[$char_position]);
            } else {
                if ($return_last) {
                    return $this->returnString($this->value[$this->length()->getValue() - 1]);
                } else {
                    $this->throwException(ERROR_OUT_OF_RANGE);
                }
            }
        } else {
            $this->throwException(ERROR_NOT_A_NUMBER);
        }
    }


    public function includeString($substring)
    {
        $substring = $this->checkForObject($substring);
        $position = strpos($this->value, $substring->getValue());
        if($position !== false){
            return $this->returnInteger($position);
        } else {
            $this->throwException(ERROR_INCLUDE);
        }
    }


    public function insert($index, $string)
    {
        $first_part = substr($this->value, 0, $index);
        $second_part = substr($this->value, $index, $this->length()->getValue() - 1);
        $new_value = $first_part . $string . $second_part;
        return $this->returnSelf($new_value);
    }


    public function length()
    {
        return $this->returnInteger(strlen($this->value));
    }

    public function generateMd5()
    {
        $md5 = md5($this->value);
        return $this->returnString($md5);
    }

    /*
     * ToDo: Make this method. Srsly!!!
     */

    public function regexp($pattern, $var)
    {
        if (gettype($var) == 'object') {
            if (get_class($var) == "Closure") {
                $this->regexpLambda($pattern, $var);
            } elseif (get_class($var) == "String") {
                $this->regexpReplacement($pattern, $var);
            } else {
                return false;
            }
        } elseif (gettype($var) == 'string') {
            $this->regexpReplacement($pattern, $var);
        } else {
            return false;
        }
    }

    /*
     * Private methods for the regexp specifying
     */
    private function regexpReplacement($pattern, $substring)
    {

    }

    private function regexpLambda($pattern, $lambda)
    {

    }


    public function replaceSubstring($char, $new_char = "", $use_register = false)
    {
        if ($use_register) {
            $new_value = str_ireplace($char, $new_char, $this->value);
            return $this->returnSelf($new_value);
        } else {
            $new_value = str_replace($char, $new_char, $this->value);
            return $this->returnSelf($new_value);
        }
    }


    public function reverse()
    {
        $new_value = strrev($this->value);
        return $this->returnSelf($new_value);
    }


    /*
     * Modifies current string, cuts everything except the substring between the entered borders
     */
    public function slice($left_border = 0, $right_border = 0)
    {
        $sliced_string = substr($this->value, $left_border, $right_border);
        return $this->returnSelf($sliced_string);
    }


    public function split($pattern)
    {
        $array = explode($pattern, $this->value);
        return $this->returnArray($array);
    }

    /*
     * If the string is not a number, throws an exception
     */
    public function toInteger()
    {
        if(is_numeric($this->value)){
            if($this->length()->getValue() > 1){
                if(intval($this->value) === 0){
                    $this->throwException(ERROR_NOT_A_NUMBER);
                } else {
                    return $this->returnInteger(intval($this->value));
                }
            } else {
                return $this->returnInteger(intval($this->value));
            }
        } else {
            $this->throwException(ERROR_NOT_A_NUMBER);
        }
    }


    public static function __toObject()
    {
        foreach ($GLOBALS as &$pNode) {
            if (!is_string($pNode)) {
                continue;
            }

            $pNode = new self($pNode);
        }
    }

    #~~~~~~~~~~~~~Privates


    /*
     * Method for checking the entered data. If it is just a string, it creates an object, based on string
     */
    private function checkForObject($object)
    {
        if (is_string($object)) {
            return new self($object);
        } elseif (get_class($object) == "String") {
            return $object;
        }

    }


}
