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
    function testCreation(){
        $integer = new Integer(42);
        $this->assertEqual($integer->getValue(), 42);

        $integer = new Integer("42");
        $this->assertEqual($integer->getValue(), 42);

        $integer = new Integer("test");
        $this->assertFalse($integer->getValue());

        $integer = new Integer("42test");
        $this->assertFalse($integer->getValue());
    }

    function testEven(){
        $integer = new Integer(2);
        $this->assertTrue($integer->even()->getValue());
        $this->assertFalse($integer->odd()->getValue());
    }

    function testOdd(){
        $integer = new Integer(3);
        $this->assertTrue($integer->odd()->getValue());
        $this->assertFalse($integer->even()->getValue());
    }

    function testIncrement(){
        $integer = new Integer(3);
        $this->assertEqual($integer->increment()->getValue(), 4);
    }


}