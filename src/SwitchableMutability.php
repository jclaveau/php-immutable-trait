<?php
/**
 * SwitchableMutability
 *
 * @package php-immutable-trait
 * @author  Jean Claveau
 */
namespace JClaveau\Traits;

/**
 * This trait provides the methodes to change the mutability at runtime.
 *
 * This trait requires Immutable trait to work.
 */
trait SwitchableMutability
{
    /**
     * Sets the current instance as immutable.
     *
     * @return $this
     */
    public function becomesImmutable()
    {
        $this->isImmutable = true;
        return $this;
    }

    /**
     * Sets the current instance as mutable.
     *
     * @return $this
     */
    public function becomesMutable()
    {
        $this->isImmutable = false;
        return $this;
    }

    /**/
}
