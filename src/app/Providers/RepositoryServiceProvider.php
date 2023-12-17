<?php

namespace App\Providers;

use App\Interface\V1\Auth\AuthInterface;
use App\Interface\V1\User\UserInterface;
use App\Interface\V1\App\SettingInterface;
use App\Interface\V1\Music\MusicInterface;
use App\Repository\V1\Auth\AuthRepository;
use App\Repository\V1\User\UserRepository;
use App\Repository\V1\App\SettingRepository;
use App\Repository\V1\Music\MusicRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register():void
    {
        // Binding Interfaces to its Repository
        $this->app->bind(AuthInterface::class, AuthRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(SettingInterface::class, SettingRepository::class);
        $this->app->bind(MusicInterface::class, MusicRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
