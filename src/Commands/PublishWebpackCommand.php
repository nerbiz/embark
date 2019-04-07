<?php

namespace Nerbiz\Embark\Commands;

use Illuminate\Console\Command;
use Nerbiz\Embark\ConsoleMessages\WebpackMessages;
use Nerbiz\Embark\EmbarkServiceProvider;

class PublishWebpackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'embark:webpack';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish webpack.mix.js file, using custom public directory name';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $webpackMessages = app()->make(
            WebpackMessages::class,
            ['command' => $this]
        );

        $webpackMessages->warnDestructive();
        $webpackMessages->infoDescribe();
        $confirmed = $webpackMessages->askConfirmation();

        // Show 'aborting' text when the user didn't confirm
        if ($confirmed !== true) {
            $webpackMessages->infoAborted();
            return false;
        }

        // Get the stub content and adjust it
        $webpackStub = str_replace(
            'DummyPublicDirname',
            rtrim(config('embark.public_directory_name'), '/'),
            file_get_contents(EmbarkServiceProvider::getStubsPath('resources/webpack.mix.stub'))
        );

        // Update the file
        file_put_contents(base_path('webpack.mix.js'), $webpackStub);

        $webpackMessages->infoSucceeded();
    }
}
