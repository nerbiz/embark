<?php

namespace Nerbiz\Embark\Restructure;

interface RestructureInterface
{
    /**
     * Perform the restructuring operations
     * @return void
     */
    public function restructure();

    /**
     * Show some text that confirms aborting
     * @return void
     */
    public function showSucceededText();

    /**
     * Show some text that confirms aborting
     * @return void
     */
    public function showFailedText();
}
