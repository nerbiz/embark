<?php

namespace Nerbiz\Embark;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * Specify the public directory path
     * @return string
     */
    public function publicPath()
    {
        return realpath($this->basePath . '/../' . config('embark.public_directory_name'));
    }
}
