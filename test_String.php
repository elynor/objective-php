<?php
/**
 * User: michael
 * Date: 2/15/13
 * Time: 5:46 PM
 */

require_once('simpletest/autorun.php');
include "ObjectPhpIncluder.php";

class test_String extends UnitTestCase
{

    function testForEmptiness(){
        $string = new String("Test");
        $this->assertFalse($string->isEmpty());
    }

    function testEquality(){
        $String_0 = new String("Test");
        $String_1 = $String_0->getClone();
        $this->assertTrue($String_0->equals($String_1));
        $this->assertFalse($String_0->equals("123"));
    }

    function testHashCode(){
        $String = new String("Test");
        $this->assertEqual($String->getHashCode(), spl_object_hash($String));
    }

    function  testAdding(){
        $string = new String("Test");
        $string->add("lol");
        $this->assertEqual($string->getValue(), "Testlol");

        $string->add(123);
        $this->assertEqual($string->getValue(), "Testlol123");

        $string->add("123");
        $this->assertEqual($string->getValue(), "Testlol123123");

        $string->add("$:");
        $this->assertEqual($string->getValue(), "Testlol123123$:");

        //You can add arrays
        $array = array('this', 'is', 'an array');
        $string->add($array);
        $this->assertEqual($string->getValue(), "Testlol123123$:thisisan array");

        $string->setValue("");
        $hash = array(
            "test" => "test",
            "first" => "element"
        );
        $string->add($hash);
        $this->assertEqual($string->getValue(), "testelement");
    }

    function testLength(){
        $string = new String("Test");
        $this->assertEqual($string->length()->getValue(), 4);
    }

    function testCompare(){
        $string = new String("Test");
        $this->assertEqual($string->compare("test123")->getValue(), -1);

        $other_string = new String("lol");
        $this->assertEqual($string->compare($other_string)->getValue(), 1);
    }

    function testCapitalize(){
        $string = new String("test");
        $this->assertEqual($string->capitalize()->getValue(), "Test");

        $string = new String("tEsT");
        $this->assertEqual($string->capitalize()->getValue(), "Test");
    }

    function testClear(){
        $string = new String("Test");
        $string->clear();
        $this->assertEqual($string->getValue(), "");
        $this->assertTrue($string->isEmpty());
    }

    function testSlice(){
        $string = new String("Test");

        $this->assertEqual($string->slice(0, 2)->getValue(), "Te");

        $string = new String("Test");
        $this->assertEqual($string->slice(2, 1)->getValue(), "s");

        $string = new String("Test");
        $this->assertEqual($string->slice(0, 428)->getValue(), "Test");
    }

    function test_getChar(){
        $string = new String("Test");
        $this->assertEqual($string->getChar(0), "T");
        $this->assertEqual($string->getChar(123), "t");
    }

    function testEach(){
        $string = new String("{name:'Ivan', surname:'Ivanov', age:'35'}");
        $value = $string->each(",", function ($substring) {
            $substring->setValue("ZZZ ");
            return $substring;
        });

        $this->assertEqual($value->getValue(), "ZZZ ZZZ ZZZ ");

        //If lambda will not do anything with the substrings, only the patterns will be cut

        $string = new String("{name:'Ivan', surname:'Ivanov', age:'35'}");

        $value = $string->each(",", function () {
            $aaa = 1;
        });

        $this->assertEqual($value->getValue(), "{name:'Ivan' surname:'Ivanov' age:'35'}");

        //If there will be more then 1 argument, value will be false

        $string = new String("{name:'Ivan', surname:'Ivanov', age:'35'}");

        $value = $string->each(",", function ($substring, $substring1, $substring2, $substring3) {
            $substring->setValue("ZZZ ");
            return $substring;
        });

        $this->assertFalse($value->getValue());

    }

    function testReplaceSubstring(){
        $string = new String("Test");
        $this->assertEqual($string->replaceSubstring("T")->getValue(), "est");
        $string = new String("Test");
        $this->assertEqual($string->replaceSubstring("t", "", true)->getValue(), "es");
        $string = new String("Test");
        $this->assertEqual($string->replaceSubstring("Te", "Lo", true)->getValue(), "Lost");
    }

    function testIncludeString(){
        $string = new String("Test");
        $this->assertEqual($string->includeString("T")->getValue(), 0);
        $this->assertFalse($string->includeString("LOL")->getValue());
    }

    function testInsert(){
        $string = new String("Test");
        $this->assertEqual($string->insert(2, "LOL")->getValue(), "TeLOLst");
        $string = new String("Test");
        $this->assertEqual($string->insert(42, "LOL")->getValue(), "TestLOL");
    }

    function testCount(){
        $string = new String("Test");
        $this->assertEqual($string->count("e")->getValue(), 1);
        $string->add("eee");
        $this->assertEqual($string->count("e")->getValue(), 4);
    }

    function testMd5(){
        $string = new String("Test");
        $this->assertEqual($string->generateMd5()->getValue(), md5("Test"));
    }

    function testEscape(){
        $string = new String("test'string");
        $this->assertEqual($string->escape()->getValue(), "test\'string");
    }

    function testReverse(){
        $string = new String("Test");
        $this->assertEqual($string->reverse()->getValue(), "tseT");
    }

    function testToInt(){
        $string = new String("42");
        $this->assertEqual($string->toInteger()->getValue(), 42);
        $string->setValue("0");
        $this->assertEqual($string->toInteger()->getValue(), 0);
        $string->setValue("e");
        $this->assertFalse($string->toInteger()->getValue());
        $string->setValue("e23");
        $this->assertFalse($string->toInteger()->getValue());
    }

}

?>