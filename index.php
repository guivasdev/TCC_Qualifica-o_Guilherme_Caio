<?php
require_once __DIR__ . '/model/AtaRepository.php';
require_once __DIR__ . '/model/AtaModel.php';
require_once __DIR__ . '/controller/AtaController.php';
require_once __DIR__ . '/view/AtaScreen.php';

$repo = new AtaRepository();
$model = new AtaModel($repo);
$view = new AtaScreen();
$controller = new AtaController($model, $view);

// Controle de fluxo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Quando o botão "Gerar ATA" é clicado
    $controller->gerarAta();
} else {
    // Primeira vez que o usuário entra
    $controller->buscarAta();
}
