<?php
/**
 * User: michael
 * Date: 3/18/13
 * Time: 4:31 PM
 */
include "AbstractObjectCreator.php";
/*
 * Boolean creator class
 */
class BooleanCreator extends AbstractObjectCreator
{

    static function create($value)
    {
        return new Boolean($value);
    }
}

class IntegerCreator extends AbstractObjectCreator
{
    static function create($value)
    {
        return new Integer($value);
    }
}

class StringCreator extends AbstractObjectCreator
{
    static function create($value)
    {
        return new String($value);
    }
}

class FloatCreator extends AbstractObjectCreator
{
    static function create($value)
    {
        return new Float($value);
    }
}

class ArrayCreator extends AbstractObjectCreator
{
    static function create($value)
    {
        return new ObjectiveArray($value);
    }
}

