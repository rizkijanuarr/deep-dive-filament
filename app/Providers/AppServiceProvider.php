<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \Illuminate\Database\Eloquent\Model::unguard();  // dengan nulis ini gak perlu capek capek nulis fillable atau guarded di Model.
    }
}
