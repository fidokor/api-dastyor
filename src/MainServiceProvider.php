<?php

namespace Ijodkor\LaravelGenerator;

use Ijodkor\LaravelGenerator\Boot\Boot;
use Ijodkor\LaravelGenerator\Livewire\ControllerWire;
use Ijodkor\LaravelGenerator\Livewire\GeneratorWire;
use Ijodkor\LaravelGenerator\Livewire\ModelWire;
use Ijodkor\LaravelGenerator\Livewire\RequestWire;
use Ijodkor\LaravelGenerator\Livewire\ResourceWire;
use Ijodkor\LaravelGenerator\Livewire\ServiceWire;
use Illuminate\Contracts\Foundation\CachesRoutes;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class MainServiceProvider extends ServiceProvider {
//    use EventMap, ServiceBindings;

    private string $conf = "generator";
    private string $namespace;

    public function __construct($app) {
        parent::__construct($app);

        $this->namespace = Boot::ROOT;
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void {
        $this->registerEvents();
        $this->registerCommands();

        $this->registerRoutes();
        $this->registerResources();

        $this->registerLiveWire();
        $this->offerPublishing();
    }

    /**
     * Register the H job events.
     *
     * @return void
     */
    protected function registerEvents(): void {
//        $events = $this->app->make(Dispatcher::class);

//        foreach ($this->events as $event => $listeners) {
//            foreach ($listeners as $listener) {
//                $events->listen($event, $listener);
//            }
//        }
    }

    /**
     * Register the H routes.
     *
     * @return void
     */
    protected function registerRoutes(): void {
        if ($this->app instanceof CachesRoutes && $this->app->routesAreCached()) {
            return;
        }

        Route::group([
            'domain' => config("$this->namespace.domain", null),
            'prefix' => config("$this->namespace.path"),
            'namespace' => 'Ijodkor\LaravelGenerator\Http\Controllers',
            'middleware' => config("$this->namespace.middleware", 'web'),
        ], function() {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    /**
     * Register the H resources.
     *
     * @return void
     */
    protected function registerResources(): void {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', $this->namespace);
    }

    /**
     * Setup the resource publishing groups for H.
     *
     * @return void
     */
    protected function offerPublishing(): void {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../stubs/H.stub' => app_path('Providers/MainServiceProvider.php'),
            ], "$this->conf-provider");

            $this->publishes([
                __DIR__ . "/../config/$this->conf.php" => config_path("$this->conf.php"),
            ], "$this->conf-config");
        }
    }

    /**
     * Register the H Artisan commands.
     *
     * @return void
     */
    protected function registerCommands(): void {
        if ($this->app->runningInConsole()) {
            $this->commands([

            ]);
        }

//        $this->commands([Console\SnapshotCommand::class]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void {
        if (!defined('HORIZON_PATH')) {
            define('HORIZON_PATH', realpath(__DIR__ . '/../'));
        }

//        $this->app->bind(Console\WorkCommand::class, function($app) {
//            return new Console\WorkCommand($app['queue.worker'], $app['cache.store']);
//        });

        $this->configure();
//        $this->registerServices();
    }

    /**
     * Setup the configuration for H.
     *
     * @return void
     */
    protected function configure(): void {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/generator.php', $this->namespace
        );

//        H::use(config('H.use', 'default'));
    }

    /**
     * Register H's services in the container.
     *
     * @return void
     */
    protected function registerServices() {
//        foreach ($this->serviceBindings as $key => $value) {
//            is_numeric($key)
//                ? $this->app->singleton($value)
//                : $this->app->singleton($key, $value);
//        }
    }

    private function registerLiveWire(): void {
        Livewire::component(Boot::getWire("model-wire"), ModelWire::class);
        Livewire::component(Boot::getWire("controller-wire"), ControllerWire::class);
        Livewire::component(Boot::getWire("request-wire"), RequestWire::class);
        Livewire::component(Boot::getWire("service-wire"), ServiceWire::class);
        Livewire::component(Boot::getWire("resource-wire"), ResourceWire::class);
    }
}