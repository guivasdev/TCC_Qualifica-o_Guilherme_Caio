<?php

require_once __DIR__ . '/model/AtaRepository.php';
require_once __DIR__ . '/model/AtaModel.php';
require_once __DIR__ . '/controller/AtaController.php';
require_once __DIR__ . '/view/AtaScreen.php';

$repo = new AtaRepository();
$model = new AtaModel($repo);
$view = new AtaScreen();
$controller = new AtaController($model, $view);

// Pega a ação da URL
$acao = $_GET['acao'] ?? 'buscar';

// Decide o fluxo
switch ($acao) {

    case 'gerar':
        $controller->gerarAta();   // salva e valida
        break;
    default:
        $controller->buscarAta();
        break;
}
