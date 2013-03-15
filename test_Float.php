<?php
/**
 * User: michael
 * Date: 3/11/13
 * Time: 5:16 PM
 */

    require_once('simpletest/autorun.php');
    include "ObjectPhpIncluder.php";

class test_Float extends UnitTestCase
{
    function testCreation(){
        $float = new Float("1.234");
        $this->assertEqual($float->getValue(), 1.234);

        $float = new Float("1,234");
        $this->assertEqual($float->getValue(), 1.234);
    }

    function testRound(){
        $float = new Float('1.23456789');
        $this->assertEqual($float->round(2), '1.23');

        $float = new Float('1.23456789');
        $this->assertEqual($float->round(4), '1.2346');

        $float = new Float('1.23456789');
        $this->assertEqual($float->round(0), '1.0');
    }
}