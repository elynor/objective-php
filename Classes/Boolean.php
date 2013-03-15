<?php
/**
 * User: michael
 * Date: 3/7/13
 * Time: 2:57 PM
 */
class Boolean extends Object{
    public function __construct($var){
        if($var){
            $this->value = true;
        } else {
            $this->value = false;
        }
    }

    public function __toString(){
        return "";
    }

}