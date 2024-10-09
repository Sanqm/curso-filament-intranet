<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

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
        App::setLocale('es'); // no me quedo más remedio fuerzo que el idioma este en español de los diferentes botones, cualquier otro 
        //boton que no se cambie has de ir al archivo es.json creado y agregar traduccion
    }
}
