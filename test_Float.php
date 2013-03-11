<?php
/**
 * User: michael
 * Date: 3/11/13
 * Time: 5:16 PM
 */

    require_once('simpletest/autorun.php');
    include "ObjectPhpIncluder.php";

class test_Integer extends UnitTestCase
{
    function testCreation(){
        $float = new Float("1.234");
        $this->assertEqual($float->getValue(), 1.234);

        $float = new Float("1,234");
        $this->assertEqual($float->getValue(), 1.234);


    }
}