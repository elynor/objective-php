<?php
include "ObjectPhpIncluder.php";

/*$str = new String("Test");
echo $str->length()->getValue();

$int = new Integer(12);
echo $int->getValue();*/
/*$a = new ObjectiveArray("test", "1", "2", "3");
echo $a->lol();*/

$str = new String("ololol");
try{
    $str->includeString("123");
} catch (Exception $ex){
    echo $ex->getMessage();
}