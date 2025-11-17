<?php
// index.php (topo)
require_once __DIR__ . '/model/CadastroRepository.php';
require_once __DIR__ . '/model/Cadastro.php';
require_once __DIR__ . '/model/CadastroItem.php';
require_once __DIR__ . '/controller/CadastroController.php';
require_once __DIR__ . '/view/CadastroScreen.php';
require_once __DIR__ . '/view/AtaScreen.php';
require_once __DIR__ . "/model/AtaModel.php";
require_once __DIR__ . "/controller/AtaController.php";

// Instâncias
$repo = new CadastroRepository();
$model = new Cadastro($repo);
$model2 = new AtaModel();


$formView = new CadastroScreen(); // agora deve funcionar
$ataView = new AtaScreen();

$controller = new CadastroController($model, $formView, $ataView);
$controller2 = new AtaController($model2, $ataView);

$acao = $_GET['acao'] ?? 'buscar';

switch ($acao) {

    case 'salvar':
        $controller->salvarCadastro();
        break;

    case 'buscar':
        $controller->mostrarBusca();
        break;
    case 'gerar':
        $id = $_GET['id'] ?? null;
        $controller->mostrarPaginaAta($id);
        break;
    case 'gerar2':
        $controller2->gerarAta();

        break;

    case 'form':
        $controller->mostrarFormularioUnico();
        break;
}
