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


    function testEmptiness(){
        $array = new ObjectiveArray();
        $this->assertTrue($array->isEmpty());
    }


    function testLength(){
        $array = new ObjectiveArray(1, 2, 3, 4, 5, 6, 7, 8);
        $this->assertEqual($array->length()->getValue(), 8);

        $array = new ObjectiveArray();
        $this->assertEqual($array->length()->getValue(), 0);
    }

    /*
     * Method map mutates all of the array elements corresponding to the given block
     */
    function testMap(){
        $array = new ObjectiveArray(new String("test1"), new String("test2"), new String("test3"));
        $array->map(function($element){
            $element->capitalize();
            $element->add("-moar");
            //You should return the modified element to be saved.
            return $element;
        });
        $this->assertEqual($array[0]->getValue(), "Test1-moar");


        $array->map(function($element){
            return "123";
        });

        $this->assertEqual($array[0], "123");

        // If you'll try to use more than 1 argument, the error will rise
        try{
            $array->map(function($element, $second, $third){
                return "123";
            });
        } catch(Exception $ex){
            $this->assertEqual($ex->getMessage(), "Number of arguments is not correct");
        }
    }

    /*
     * Creates a new Objective Array, where all of the elements that fits condition will store
     */
    function testSelect(){
        $array = new ObjectiveArray(1, 2, 3, 4, 5, 6, 7, 8);
        //It returns the new object of Objective Array
        //And the block should return boolean
        $new_array = $array->select(function($element){
            return $element > 3;
        });
        $this->assertEqual($new_array[0], 4);
        //If you will try to enter more than 1 argument, error will rise too
        try{
            $array->select(function($element, $second, $third){
                return $element > 3;
            });
        } catch(Exception $ex){
            $this->assertEqual($ex->getMessage(), "Number of arguments is not correct");
        }
        //If your block will return not a boolean value, the error will rise
        try{
            $array->select(function($element){
                return "Okay";
            });
        } catch(Exception $ex){
            $this->assertEqual($ex->getMessage(), "Return value of lambda is not boolean!");
        }
    }

    /*
     * Modifies the Objective Array, removing all of the null, false, "" values.
     */
    function testCompact(){
        $array = new ObjectiveArray(1, 2, null, 3, 4, null, 5, 6, 7, 8);
        $this->assertEqual($array->length()->getValue(), 10);
        //This method cuts all null values with their array position, shrinking the array
        $array->compact();
        $this->assertEqual($array->length()->getValue(), 8);
        $this->assertEqual($array[2], 3);

    }

    function testMinimize(){
        //If there is a primitive type in array, the String would be created
        $array = new ObjectiveArray("Test");
        $result = $array->minimize()->add("11");
        $this->assertEqual($result, "Test11");


        //If there would be an object, this method would return an object.
        $array = new ObjectiveArray(new Integer(123));
        $result = $array->minimize()->increment();
        $this->assertEqual($result->getValue(), 124);
    }

    function testFindElement(){
        $array = new ObjectiveArray(1, 3, 8, 21, "Test", new String("Test21"));
        $position = $array->findElement(8)->minimize();
        $this->assertEqual($position->getValue(), 2);

        $string = new String("Test21");
        $position = $array->findElement($string)->minimize();
        $this->assertEqual($position->getValue(), 5);
        //Result array would be empty if the search string would not be found.
        $position = $array->findElement("123");
        $this->assertTrue($position->isEmpty());
    }

    function testDeleteElement(){
        $array = new ObjectiveArray(1, 3, 8, 21, 3, "Test", 3, new String("Test21"));
        $this->assertEqual($array->length()->getValue(), 8);
        $array->delete(3);
        $array->compact();
        $this->assertEqual($array->length()->getValue(), 5);
    }



}