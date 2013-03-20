<?php
/**
 * User: michael
 * Date: 2/15/13
 * Time: 1:28 PM
 */
/*
 * Hate it, but i need to extend only 1 object. So I will create all of the Object methods. Hate it T_T
 */
class ObjectiveArray extends ArrayObject
{
    public function __construct(){
        if(func_num_args() == 1){
            $first_argument = func_get_arg(0);
                if(is_array($first_argument)){
                    parent::__construct($first_argument);
                } else {
                    $arguments = func_get_args();
                    parent::__construct($arguments);
                }
            }
        if(func_num_args() > 1){
            $arguments = func_get_args();
            parent::__construct($arguments);
        }
    }

    /*
     * Object methods.
     */

    public function isEmpty()
    {
        if (empty($this) ||
            $this->value === false
        ) {
            return true;
        } else {
            return false;
        }
    }


    public function returnBooleanObject(){

    }

}
