<?php

namespace Hamato\ArtisanGitTools;

use Illuminate\Support\ServiceProvider;
use Hamato\ArtisanGitTools\Console\TimetravelCommand;

class ArtisanGitToolsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->commands([
            TimetravelCommand::class,
        ]);
    }

}