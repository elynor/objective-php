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
        $this->assertFalse($string->isEmpty()->getValue());
    }

    function testEquality(){
        $String_0 = new String("Test");
        $String_1 = $String_0->getClone();
        $this->assertTrue($String_0->equals($String_1));
        $this->assertFalse($String_0->equals("123")->getValue());
    }

    function testHashCode(){
        $String = new String("Test");
        $this->assertEqual($String->getHashCode(), spl_object_hash($String));
    }

    function  testAdding(){
        $string = new String("Test");
        $string->add("lol");
        $this->assertEqual($string, "Testlol");

        $string->add(123);
        $this->assertEqual($string, "Testlol123");

        $string->add("123");
        $this->assertEqual($string, "Testlol123123");

        $string->add("$:");
        $this->assertEqual($string, "Testlol123123$:");

        //You can add arrays
        $array = array('this', 'is', 'an array');
        $string->add($array);
        $this->assertEqual($string, "Testlol123123$:thisisan array");

        $string->setValue("");
        $hash = array(
            "test" => "test",
            "first" => "element"
        );
        $string->add($hash);
        $this->assertEqual($string, "testelement");
    }

    function testLength(){
        $string = new String("Test");
        $this->assertEqual($string->length(), "4");
    }

    function testCompare(){
        $string = new String("Test");
        $this->assertEqual($string->compare("test123")->getValue(), -1);

        $other_string = new String("lol");
        $this->assertEqual($string->compare($other_string)->getValue(), 1);
    }

    function testCapitalize(){
        $string = new String("test");
        $this->assertEqual($string->capitalize(), "Test");

        $string = new String("tEsT");
        $this->assertEqual($string->capitalize(), "Test");
    }

    function testClear(){
        $string = new String("Test");
        $string->clear();
        $this->assertEqual($string, "");
        $this->assertTrue($string->isEmpty());
    }

    function testSlice(){
        $string = new String("Test");

        $this->assertEqual($string->slice(0, 2), "Te");

        $string = new String("Test");
        $this->assertEqual($string->slice(2, 1), "s");

        $string = new String("Test");
        $this->assertEqual($string->slice(0, 428), "Test");
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

        $this->assertEqual($value, "ZZZ ZZZ ZZZ ");

        //If lambda will not do anything with the substrings, only the patterns will be cut

        $string = new String("{name:'Ivan', surname:'Ivanov', age:'35'}");

        $value = $string->each(",", function () {
            $aaa = 1;
        });

        $this->assertEqual($value, "{name:'Ivan' surname:'Ivanov' age:'35'}");

        //If there will be more then 1 argument, exception will rise


        $string = new String("{name:'Ivan', surname:'Ivanov', age:'35'}");

        try{
        $value = $string->each(",", function ($substring, $substring1, $substring2, $substring3) {
            $substring->setValue("ZZZ ");
            return $substring;
        });
        } catch(Exception $ex){
            $this->assertEqual($ex->getMessage(), "Number of arguments is not valid!");
        }


    }

    function testReplaceSubstring(){
        $string = new String("Test");
        $this->assertEqual($string->replaceSubstring("T"), "est");
        $string = new String("Test");
        $this->assertEqual($string->replaceSubstring("t", "", true), "es");
        $string = new String("Test");
        $this->assertEqual($string->replaceSubstring("Te", "Lo", true), "Lost");
    }

    function testIncludeString(){
        $string = new String("Test");
        $this->assertEqual($string->includeString("T")->getValue(), 0);

        try{
            $string->includeString("LOL");
        }catch (Exception $ex){
            $this->assertEqual($ex->getMessage(), "There is no such substring in this string!");
        }


    }

    function testInsert(){
        $string = new String("Test");
        $this->assertEqual($string->insert(2, "LOL"), "TeLOLst");
        $string = new String("Test");
        $this->assertEqual($string->insert(42, "LOL"), "TestLOL");
    }

    function testCount(){
        $string = new String("Test");
        $this->assertEqual($string->count("e")->getValue(), 1);
        $string->add("eee");
        $this->assertEqual($string->count("e")->getValue(), 4);
    }

    function testMd5(){
        $string = new String("Test");
        $this->assertEqual($string->generateMd5(), md5("Test"));
    }

    function testEscape(){
        $string = new String("test'string");
        $this->assertEqual($string->escape(), "test\'string");
    }

    function testReverse(){
        $string = new String("Test");
        $this->assertEqual($string->reverse(), "tseT");
    }

    function testToInt(){
        $string = new String("42");
        $this->assertEqual($string->toInteger()->getValue(), 42);
        $string->setValue("0");
        $this->assertEqual($string->toInteger()->getValue(), 0);

        //If it is not a number, the exception will rise
        $string->setValue("e");
        try{
            $string->toInteger()->getValue();
        }catch (Exception $ex){
            $this->assertEqual($ex->getMessage(), "This is not a number!");
        }

        //Same story
        $string->setValue("e23");
        try{
            $string->toInteger()->getValue();
        }catch (Exception $ex){
            $this->assertEqual($ex->getMessage(), "This is not a number!");
        }
    }

}

?>