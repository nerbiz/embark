<?php

namespace Nerbiz\Embark\ConsoleMessages;

class WebpackMessages extends AbstractConsoleMessages
{
    /**
     * Describe what will be changed
     * @return void
     */
    public function infoDescribe()
    {
        $this->command->info('webpack.mix.js will be overwritten');
    }
}
