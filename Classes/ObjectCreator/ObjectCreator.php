<?php
/**
 * User: michael
 * Date: 3/18/13
 * Time: 4:31 PM
 */
class BooleanCreator extends AbstractObjectCreator
{

    public function create($value)
    {
        return new Boolean($value);
    }
}
