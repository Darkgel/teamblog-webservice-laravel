<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //debug模式下记录sql查询语句
        if(config('app.debug') === true){
            \DB::listen(function ($query) {
                \Log::channel('sql')->info(
                    '{sql query:'.json_encode($query->sql, JSON_UNESCAPED_UNICODE).'}---{bindings:'.json_encode($query->bindings, JSON_UNESCAPED_UNICODE).'}---{time:'.json_encode($query->time, JSON_UNESCAPED_UNICODE).'}');
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
