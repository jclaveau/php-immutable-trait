<?php
namespace JClaveau\Traits;

class TestObject
{
    use Immutable;

    protected $property = 'lululu';
    protected $refProperty;

    public function setProperty($value)
    {
        if ($this->callOnCloneIfImmutable($result))
            return $result;

        $this->property = $value;
        return $this;
    }

    public function getProperty()
    {
        return $this->property;
    }

    public function setRefProperty(&$value)
    {
        if ($this->callOnCloneIfImmutable($result))
            return $result;

        $this->refProperty = $value;
        return $this;
    }

    public function getRefProperty()
    {
        return $this->refProperty;
    }
}

/**
 */
class ImmutableTest extends \AbstractTest
{
    /**
     */
    public function test_mutable()
    {
        $instance = new TestObject();
        $instance->setProperty('lalala');
        $this->assertEquals('lalala', $instance->getProperty());
        $this->assertTrue( $instance->isMutable() );
    }

    /**
     */
    public function test_immutable()
    {
        $instance = new TestObject();
        $instance2 = $instance->setImmutable()->setProperty('lalala');

        $this->assertEquals( 'lululu', $instance->getProperty() );
        $this->assertEquals( 'lalala', $instance2->getProperty() );
        $this->assertFalse( $instance->isMutable() );
        $this->assertFalse( $instance2->isMutable() );
    }

    /**
     */
    public function test_call_method_with_args_by_ref()
    {
        $myString = 'lalala';

        $instance = new TestObject();
        $instance2 = $instance->setImmutable()->setRefProperty($myString);

        $this->assertEquals( null, $instance->getRefProperty() );
        $this->assertEquals( 'lalala', $instance2->getRefProperty() );
        $this->assertSame( $myString, $instance2->getRefProperty() );
    }

    /**
     */
    public function test_setMutable()
    {
        $instance = new TestObject();
        $instance2 = $instance->setImmutable()->setProperty('plop');

        $this->assertSame( $instance2, $instance2->setMutable()->setProperty('plop2') );
        $this->assertEquals( 'plop2', $instance2->getProperty() );
    }

    /**/
}
