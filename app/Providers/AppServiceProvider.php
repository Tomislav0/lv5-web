<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Blade::if('isNotStudent', function () {

            $user = User::where('id', Auth::id())->get();
            return $user[0]->role !== config('roles.student');
        });

        Blade::if('checkRole', function ($role) {
            
            $user = User::where('id',Auth::id())->first();
            Log::info(Auth::id());
            Log::info($user);
            if ($role === 'student') {
                return $user->role === config('roles.student');
            }
            if ($role === 'teacher') {
                return $user->role === config('roles.teacher');
            }
            if ($role === 'admin') {
                return $user->role === config('roles.admin');
            }
            return false;
        });
    }

}
