<?php
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
        $this->view->mostrarBuscaATA([
            'status' => 'aguardando',
            'mensagem' => 'Preencha os campos e gere uma nova ATA.'
        ]);
    }
}
?>
