<?php

namespace App\Providers;

use App\Activity;
use App\Debt;
use App\Gift;
use App\Kid;
use App\Note;
use App\Reminder;
use App\SignificantOther;
use App\Task;
use Route;
use App\Contact;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::bind('contact', function ($value) {
            return Contact::where('account_id', auth()->user()->account_id)
                ->where('id', $value)
                ->firstOrFail();
        });

        Route::bind('activity', function($value, $route) {
            return  Activity::where('account_id', auth()->user()->account_id)
                ->where('contact_id', $route->parameter('contact')->id)
                ->where('id', $value)
                ->firstOrFail();
        });

        Route::bind('reminder', function($value, $route) {
            return  Reminder::where('account_id', auth()->user()->account_id)
                ->where('contact_id', $route->parameter('contact')->id)
                ->where('id', $value)
                ->firstOrFail();
        });

        Route::bind('task', function($value, $route) {
            return  Task::where('account_id', auth()->user()->account_id)
                ->where('contact_id', $route->parameter('contact')->id)
                ->where('id', $value)
                ->firstOrFail();
        });

        Route::bind('gift', function($value, $route) {
            return  Gift::where('account_id', auth()->user()->account_id)
                ->where('contact_id', $route->parameter('contact')->id)
                ->where('id', $value)
                ->firstOrFail();
        });

        Route::bind('debt', function($value, $route) {
            return  Debt::where('account_id', auth()->user()->account_id)
                ->where('contact_id', $route->parameter('contact')->id)
                ->where('id', $value)
                ->firstOrFail();
        });

        Route::bind('significant_other', function($value, $route) {
            return  SignificantOther::where('account_id', auth()->user()->account_id)
                ->where('contact_id', $route->parameter('contact')->id)
                ->where('id', $value)
                ->firstOrFail();
        });

        Route::bind('kid', function($value, $route) {
            return  Kid::where('account_id', auth()->user()->account_id)
                ->where('child_of_contact_id', $route->parameter('contact')->id)
                ->where('id', $value)
                ->firstOrFail();
        });

        Route::bind('note', function($value, $route) {
            return  Note::where('account_id', auth()->user()->account_id)
                ->where('contact_id', $route->parameter('contact')->id)
                ->where('id', $value)
                ->firstOrFail();
        });
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
