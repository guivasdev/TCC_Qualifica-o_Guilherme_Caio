<?php
// index.php (topo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

    case 'salvarForm':
        $controller->salvarCadastro();
        break;

    case 'buscar':
        $controller->mostrarBusca();
        break;
        
    case 'gerar':
        $id = $_GET['id'] ?? null;

    if ($id !== null) {
        $controller->mostrarPaginaAta((int)$id);
    } else {
        // Nenhum ID enviado, mostra formulário vazio
        $controller->mostrarPaginaAta(null, false); // podemos usar um segundo parâmetro para não buscar último
    }
    break;
    case 'gerarAta':
        $controller2->gerarAta();

        break;

    case 'form':
        $controller->mostrarFormularioUnico();
        break;
}
