<?php
include "ObjectPhpIncluder.php";

/*$str = new String("Test");
echo $str->length()->getValue();

$int = new Integer(12);
echo $int->getValue();*/

$test_integer = new Integer(123);
echo $test_integer;

$test_integer = new Integer(123);
if($test_integer->getValue() == 123){
    echo "Done";
}
