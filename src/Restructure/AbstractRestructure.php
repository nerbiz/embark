<?php

namespace Nerbiz\Embark\Restructure;

abstract class AbstractRestructure
{
    /**
     * Whether or not the user confirmed to continue
     * @var bool
     */
    protected $confirmed;

    /**
     * Check if the restructuring is done already
     * @return bool
     */
    abstract public function isDoneAlready(): bool;

    /**
     * Perform the restructuring operations
     * @return bool Indicates if the restructuring succeeded or not
     */
    abstract public function restructure(): bool;

    /**
     * @return bool
     */
    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    /**
     * @param bool $confirmed
     * @return void
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;
    }
}
