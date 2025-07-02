<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Faker\Provider\HardwareDB\Produtos;
use Faker\Provider\HardwareDB\ProdutosParceiros;
use Faker\Provider\HardwareDB\Categorias;

class HardwareDBServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Caminho para a pasta onde estão as classes
        $path = app_path('CustomClasses/Faker/Provider');

        // Itera sobre os arquivos PHP na pasta
        foreach (File::allFiles($path) as $file) {
            // Constrói o namespace completo, incluindo subpastas
            $relativePath = $file->getRelativePath();
            $namespace = 'App\\CustomClasses\\Faker\\Provider' . ($relativePath ? '\\' . str_replace('/', '\\', $relativePath) : '');
            $class = $namespace . '\\' . $file->getFilenameWithoutExtension();

            // Verifica se a classe existe antes de registrá-la
            if (class_exists($class)) {
                // Registra a classe no container
                $this->app->bind($class, function ($app) use ($class) {
                    // Usa o container para resolver dependências
                    // return new $class();

                    // Essa linha gerava loop infinito:
                    return $app->make($class);
                    /**
                     * Resposta do Gemini
                     * O que está acontecendo:
                     *   Quando o Laravel precisa resolver uma dependência de uma das suas classes (digamos, a classe ProdutosParceiros), ele chama a função de closure que você
                     *      registrou para essa classe. Dentro dessa função, você está chamando $app->make($class) novamente. Isso diz ao Laravel para tentar criar uma instância da
                     *      mesma classe que ele já estava tentando criar.
                     *   Se essa classe (ProdutosParceiros, por exemplo) tiver dependências definidas no seu construtor (Produtos e Categorias), o Laravel tentará resolver essas
                     *      dependências chamando as closures que você definiu para elas. Se essas closures também usarem $app->make() para a mesma classe ou para outras que, por
                     *      sua vez, dependem da primeira, você pode facilmente cair em um ciclo infinito, levando ao erro do Xdebug.
                     */
                });
            }
        }

        // $this->app->bind(Categorias::class, function ($app) {
        //     return new Categorias();
        // });

        // $this->app->bind(Produtos::class, function ($app) {
        //     return new Produtos();
        // });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
