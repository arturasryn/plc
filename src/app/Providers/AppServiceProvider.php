<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\Bug;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot()
    {
        Relation::morphMap([
            'task' => Task::class,
            'bug' => Bug::class,
        ]);
    }
}
