<?php
/**
 * Immutable
 *
 * @package php-immutable-trait
 * @author  Jean Claveau
 */
namespace JClaveau\Traits;

/**
 * This trait adds the support of switchable mutability to the class you want with
 * the tools to handle it with the tighter footprint as possible.
 */
trait Immutable
{
    /** @var bool $isMutable The mutability state of the current instance */
    protected $isMutable = true;

    /**
     * This method is meant to be called at the beginning of every method that
     * must support immutability.
     * Example :
     *
     * public function setProperty($value)
     * {
     *     if ($this->callOnCloneIfImmutable($result))
     *         return $result;
     *
     *     $this->property = $value;
     *     return $this;
     * }
     *
     * @param  $methodResult Is a parameter in which the result of the call on the
     *                       cloned instance will be stored.
     *
     * @return bool          Whether or not the called method process must be stoped
     */
    protected function callOnCloneIfImmutable( &$methodResult )
    {
        // If the current instance is mutable we continue the execution of the
        // called method
        if ($this->isMutable) {
            return false;
        }

        $bt = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 4 );

        // If we are looping in recursion we bloc the recursion here (The instance
        // is cloned and we should now call the method on it)
        if (    isset($bt[3]['class'])    && $bt[3]['class']    == __CLASS__
            &&  isset($bt[3]['function']) && $bt[3]['function'] == __FUNCTION__
        ) {
            return false;
        }

        $methodResult = call_user_func_array( [clone $this, $bt[1]['function']], $bt[1]['args'] );

        return true;
    }

    /**
     * Sets the current instance as immutable.
     *
     * @return $this
     */
    public function setImmutable()
    {
        $this->isMutable = false;
        return $this;
    }

    /**
     * Sets the current instance as mutable.
     *
     * @return $this
     */
    public function setMutable()
    {
        $this->isMutable = true;
        return $this;
    }

    /**
     * Tells if the current instance is mutable or not.
     *
     * @return bool The answer
     */
    public function isMutable()
    {
        return $this->isMutable;
    }

    /**/
}
