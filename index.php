<?php
require_once 'model/AtaModel.php';
require_once 'view/AtaScreen.php';
require_once 'view/IncluirComponentes.php';

require_once 'controller/AtaController.php';

$model = new AtaModel();
$view = new AtaScreen();
$controller = new AtaController($model, $view);
$acao = $_GET['acao'] ?? 'buscar';
    $controller->gerarAta();
//$controller->buscarAta();


/*
switch($acao){
    case 'gerar':
        $controller->gerarAta();
        break;
    case 'buscar':
        $controller->buscarAta();
        break;
    case 'cadastrarComponente':
        $campo = $_GET['campo'] ?? null;
        $incluir = new IncluirComponentes();
        switch($campo){
            case 'Organização':
                $incluir->mostrarPaginaOrganizacao([]);
                break;
            case 'Curso':
                $incluir->mostrarPaginaCurso([]);
                break;
            case 'Local':
                $incluir->mostrarPaginaLocal([]);
                break;
            case 'Integrantes':
                $incluir->mostrarPaginaIntegrante([]);
           ;
        }
        break;
    default:
        $controller->buscarAta();
}
        */

?>