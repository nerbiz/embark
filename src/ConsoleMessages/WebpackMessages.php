<?php

namespace Nerbiz\Embark\ConsoleMessages;

class WebpackMessages extends AbstractMessages
{
    /**
     * Describe what will be changed
     * @return void
     */
    public function infoDescribe(): void
    {
        $this->command->info('webpack.mix.js will be overwritten');
    }
}
