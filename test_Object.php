<?php
/**
 * User: michael
 * Date: 2/15/13
 * Time: 2:40 PM
 */

require_once('simpletest/autorun.php');
require_once('ObjectPhpIncluder.php');

class ObjectTests extends UnitTestCase {

    function testForEmptiness(){
        $object = new Object();
        $this->assertTrue($object->isEmpty());
    }

    function testEquality(){
        $object_0 = new Object();
        $object_1 = $object_0->getClone();
        $this->assertTrue($object_0->equals($object_1));
        $this->assertFalse($object_0->equals("123"));
    }

    function testHashCode(){
        $object = new Object();
        $this->assertEqual($object->getHashCode(), spl_object_hash($object));
    }


}

?>