<?php

namespace App\Providers;

use App\Interface\V1\Auth\AuthInterface;
use App\Interface\V1\User\UserInterface;
use App\Interface\V1\App\SettingInterface;
use App\Interface\V1\Music\MusicInterface;
use App\Interface\V1\Film\FilmInterface;
use App\Interface\V1\Comment\CommentInterface;
use App\Interface\V1\User\UserWordInterface;
use App\Interface\V1\Dictionary\WordInterface;
use App\Interface\V1\Dictionary\IdiomInterface;

use App\Repository\V1\Auth\AuthRepository;
use App\Repository\V1\User\UserRepository;
use App\Repository\V1\App\SettingRepository;
use App\Repository\V1\Music\MusicRepository;
use App\Repository\V1\Film\FilmRepository;
use App\Repository\V1\Comment\CommentRepository;
use App\Repository\V1\User\UserWordRepository;
use App\Repository\V1\Dictionary\WordRepository;
use App\Repository\V1\Dictionary\IdiomRepository;

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
        $this->app->bind(FilmInterface::class, FilmRepository::class);
        $this->app->bind(CommentInterface::class, CommentRepository::class);
        $this->app->bind(UserWordInterface::class, UserWordRepository::class);
        $this->app->bind(WordInterface::class, WordRepository::class);
        $this->app->bind(WordInterface::class, WordRepository::class);
        $this->app->bind(IdiomInterface::class, IdiomRepository::class);
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
