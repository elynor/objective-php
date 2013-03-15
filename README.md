objective-php
=============

Library to wrap the basic php types

Well, i think that I am making the new bicycle, but I hope that this one would be useful.
For the unit testing I am using simpletest, here is the site: http://www.simpletest.org/

Just a dev. notes. I'll write full description, if it would be needed.

1) To use this wrapper, just include the file "ObjectPhpIncluder.php" into your file. An example:

<?php
include "ObjectPhpIncluder.php";

$str = new String("Test");
echo $str->length();

?>

2) If you need just echo or print a string, or integer, or something, you could just use an object. It would be
threaten like a string. But if you need a comparison between values - use ->getValue(). An example:

$test_integer = new Integer(123);
echo $test_integer;

BUT

$test_integer = new Integer(123);
if($test_integer->getValue() == 123){
    echo "Done";
}