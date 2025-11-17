<?php

class CadastroController
{
    private Cadastro $model;
    private $formView; // tipar se quiser
    private $ataView;

    public function __construct(Cadastro $model, $formView, $ataView)
    {
        $this->model    = $model;
        $this->formView = $formView;
        $this->ataView  = $ataView;
    }

    public function mostrarFormulario()
    {
        // supondo que sua view de form tenha método mostrarFormulario()
        $this->formView->mostrarFormulario();
    }

    public function salvarCadastro()
    {
        $dados = $_POST;
        $this->model->salvar($dados);

        header("Location: index.php?acao=busca");
        exit;
    }

    public function mostrarBusca()
    {
        $resultado = $this->model->buscarTodas();
        $this->ataView->mostrarBuscaATA($resultado);
    }

    public function mostrarPaginaAta($id)
    {
        $resultado = $this->model->buscarPorId($id);
        $this->ataView->mostrarPaginaATA($resultado);
    }
}
