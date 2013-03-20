<?php
/**
 * User: michael
 * Date: 3/18/13
 * Time: 2:29 PM
 */
    require_once('simpletest/autorun.php');
    include "ObjectPhpIncluder.php";

class test_Array extends UnitTestCase
{

    function testCreation(){
        $array = new ObjectiveArray("123", "test", "test1");
        $this->assertEqual($array[0], "123");

        $array = new ObjectiveArray("test");
        $this->assertEqual($array[0], "test");

        $vanilla_array = array("123", "test", "test2");
        $array = new ObjectiveArray($vanilla_array);
        $this->assertEqual($array[0], "123");
    }

}