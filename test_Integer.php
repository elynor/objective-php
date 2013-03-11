<?php
/**
 * User: michael
 * Date: 3/6/13
 * Time: 2:06 PM
 */

require_once('simpletest/autorun.php');
include "ObjectPhpIncluder.php";

class test_Integer extends UnitTestCase
{
    function justTest(){
        $int = new Integer(123);
        echo "123";
        echo $int->getValue();
    }
}