<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MessageService;
use App\Services\PostService;
use App\Services\LmkopService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // Liaison du service dans le container
        app()->singleton('message', function () {
            return new MessageService();
        });
        app()->singleton('post', function () {
            return new PostService();
        });
        app()->singleton('lmkop', function () {
            return new LmkopService();
        });
        
    }
    
    public function boot(): void
    {
        //
    }
}
