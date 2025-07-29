<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        putenv('APP_ENV=testing'); // Garante que o ambiente de teste está ativo
        putenv('FAKER_LOCALE=pt_BR');
        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=:memory:');

        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
