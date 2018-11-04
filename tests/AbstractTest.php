<?php
/**
 *
 */

class AbstractTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
    }

    public function setUp()
    {
        echo( get_called_class() . '::' . $this->getName() ."\n" );
    }

    /**/
}
