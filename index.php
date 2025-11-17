<?php
// index.php (topo)
require_once __DIR__ . '/model/CadastroRepository.php';
require_once __DIR__ . '/model/Cadastro.php';
require_once __DIR__ . '/model/CadastroItem.php';
require_once __DIR__ . '/controller/CadastroController.php';

// Views - garanta que os ficheiros existam exatamente nesses caminhos
require_once __DIR__ . '/view/CadastroScreen.php';
require_once __DIR__ . '/view/AtaScreen.php';

// Instâncias
$repo = new CadastroRepository();
$model = new Cadastro($repo);

$formView = new CadastroScreen(); // agora deve funcionar
$ataView  = new AtaScreen();

$controller = new CadastroController($model, $formView, $ataView);


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

    default:
        $controller->mostrarFormulario();
        break;
}
