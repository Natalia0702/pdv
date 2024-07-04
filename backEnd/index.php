<?php

require 'vendor/autoload.php';
require 'app/Core/core.php';
$pdo = require 'Connection.php';
require 'app/Controller/ProdutoController.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

handleCors();

$path = $_SERVER['REQUEST_URI'];
// var_dump($path);
// $routes = [
//     '/' => 'index.php',
//     '/listarProdutos' => 'index.php',
//     '/contato' => 'app/Template/contato.html'
// ];

if($path == '/listarProdutos') {
    $produtoController = new ProdutoController($pdo);
    header('Content-Type: application/json');
    $resultado = $produtoController->listarProdutos($id);
    echo json_encode($resultado);
}

if($path === '/salvarProduto') {
    $produtoController = new ProdutoController($pdo);
    header('Content-Type: application/json');
    $postData = file_get_contents("php://input");
    $data = json_decode($postData);

    $nome = $data->nome;
    $preco_custo = $data->preco_custo;
    $preco_venda = $data->preco_venda;
    $tipo_produto_id = $data->tipo_produto_id;

    $produtoController->criarProduto($nome, $preco_custo, $preco_venda, $tipo_produto_id);
    echo 'Produto salvo com sucesso!';
}

if($path === '/listarProdutosTipoProduto') {
    $produtoController = new ProdutoController($pdo);
    header('Content-Type: application/json');
    $resultado = $produtoController->listarProdutosTipoProduto();
    echo json_encode($resultado);
}

