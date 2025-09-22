<?php
require_once 'model/AtaModel.php';
require_once 'view/AtaScreen.php';
require_once 'view/IncluirComponentes.php'; // ajuste o caminho conforme seu projeto

class AtaController {
    private $model;
    private $view;

    public function __construct($model, $view){
        $this->model = $model;
        $this->view = $view;
    }

    public function gerarAta(){
        $resultado = $this->model->criarAta();
        $this->view->mostrarPaginaATA($resultado);
    }

    public function buscarAta(){
        $resultado = $this->model->buscarAta();
        $this->view->mostrarBuscaATA($resultado);
    }
}
?>
