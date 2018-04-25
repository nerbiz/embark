<?php

namespace Nerbiz\Embark\Restructure;

abstract class AbstractRestructure
{
    /**
     * Whether or not the user confirmed to continue
     * @var boolean
     */
    protected $confirmed;

    /**
     * Check if the restructuring is done already
     * @return boolean
     */
    abstract public function isDoneAlready();

    /**
     * Perform the restructuring operations
     * @return boolean Indicates if the restructuring succeeded or not
     */
    abstract public function restructure();

    /**
     * @return boolean
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @param boolean $confirmed
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;
    }
}
