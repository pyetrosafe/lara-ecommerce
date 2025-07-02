<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Faker\Provider\HardwareDB\HardwareDatabase;

class HardwareDBController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return ltrim(substr(str_replace('.php', '', __FILE__), strlen(str_replace(DIRECTORY_SEPARATOR . 'public', '', $_SERVER['DOCUMENT_ROOT']))), DIRECTORY_SEPARATOR);

        $hdb = new HardwareDatabase();
        // $hdb = app(HardwareDatabase::class);

        // echo "<h2>Informações de Categorias:</h2>";
        // echo "Nome da categoria com ID 1: " . $hdb->getCategoriaNome(1) . "<br>";
        // echo "Lista de todas as categorias:<pre>";
        // print_r($hdb->listarCategorias());
        // echo "</pre>";

        // echo "<h2>Informações de Marcas:</h2>";
        // echo "Nome da marca com ID 3: " . $hdb->getMarcaNome(3) . "<br>";
        // echo "Lista de todas as marcas:<pre>";
        // print_r($hdb->listarMarcas());
        // echo "</pre>";

        // echo "<h2>Informações de Modelos:</h2>";
        // echo "Detalhes do modelo com ID 101:<pre>";
        // print_r($hdb->getModelo(101));
        // echo "</pre>";
        // echo "Lista de todos os modelos (primeiros 5):<pre>";
        // print_r(array_slice($hdb->listarModelos(), 0, 5));
        // echo "</pre>";

        // echo "<h2>Informações de Produtos:</h2>";
        // echo "Detalhes do produto com ID 1:<pre>";
        // print_r($hdb->getProduto(1));
        // echo "</pre>";
        // echo "Detalhes do produto com ID 23 (que tem parceiros):<pre>";
        // print_r($hdb->getProduto(23));
        // echo "</pre>";
        // echo "Lista de todos os produtos (primeiros 5):<pre>";
        // print_r(array_slice($hdb->listarProdutos(), 0, 3));
        // echo "</pre>";

        // echo "<h2>Informações de Produtos Parceiros:</h2>";
        // echo "Lista de todos os produtos parceiros:<pre>";
        // print_r($hdb->listarProdutosParceiros());
        // echo "</pre>";

        // echo "<h2>Adicionando Novos Dados:</h2>";
        // $hdb->adicionarMarca(15, 'Gigabyte');
        // echo "Nome da marca com ID 15: " . $hdb->getMarcaNome(15) . "<br>";

        // $hdb->adicionarModelo(2201, 15, 'RTX 4070 Ti Eagle OC');
        // echo "Detalhes do modelo com ID 2201:<pre>";
        // print_r($hdb->getModelo(2201));
        // echo "</pre>";

        // $hdb->adicionarProduto(301, 2201, 'RTX 4070 Ti Eagle OC 12GB', 2);
        // echo "Detalhes do produto com ID 301:<pre>";
        // print_r($hdb->getProduto(301));
        // echo "</pre>";

        // $hdb->adicionarProdutoParceiro(301, 2201);
        // echo "Detalhes do produto com ID 301 (após ser adicionado como parceiro):<pre>";
        // print_r($hdb->getProduto(301));
        // echo "</pre>";

        // echo "<h2>Listas Completas (Abreviadas):</h2>";
        // echo "Primeiras 3 categorias:<pre>";
        // print_r(array_slice($hdb->listarCategorias(), 0, 3));
        // echo "</pre>";
        // echo "Primeiras 3 marcas:<pre>";
        // print_r(array_slice($hdb->listarMarcas(), 0, 3));
        // echo "</pre>";
        // echo "Primeiros 3 modelos:<pre>";
        // print_r(array_slice($hdb->listarModelos(), 0, 3));
        // echo "</pre>";
        // echo "Primeiros 3 produtos:<pre>";
        // print_r(array_slice($hdb->listarProdutos(), 0, 3));
        // echo "</pre>";
        // echo "Primeiros 3 produtos parceiros:<pre>";
        // print_r(array_slice($hdb->listarProdutosParceiros(), 0, 3));
        // echo "</pre>";

        // echo "Produtos/parceiros:<pre>";
        // print_r($hdb->getProdutos());
        // echo "</pre>";

        echo "Produtos/parceiros título venda:<pre>";
        print_r($hdb->getProdutosTituloVenda());
        echo "</pre>";
    }
}
