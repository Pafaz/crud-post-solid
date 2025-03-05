<?php

namespace App\Providers;

use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use App\Repositories\CategoryRepository;
use App\Interfaces\TagInterface;
use App\Interfaces\PostInterface;
use App\Interfaces\CommentInterface;
use App\Interfaces\CategoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TagInterface::class, TagRepository::class);
        $this->app->bind(CommentInterface::class, CommentRepository::class);
        $this->app->bind(PostInterface::class, PostRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
