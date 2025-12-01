<?php
require_once __DIR__ . "/../../model/classes/Cargo.php";
require_once __DIR__ . "/../../model/classes/Curso.php";
require_once __DIR__ . "/../../model/classes/Integrante.php";
require_once __DIR__ . "/../../model/classes/NucleoInstitucional.php";
require_once __DIR__ . "/../../model/classes/Organizacao.php";
require_once __DIR__ . "/../../model/classes/Local.php";


class AtaController
{
    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    public function gerarAta()
    {
        $cursos = (new Curso())->getALLCursos();
        $cargos = (new Cargo())->getALLCargos();
        $integrantes = (new Integrante())->getALLIntegrantes();
        $nucleos = (new NucleoInstitucional())->getALLNucleoInstitucional();
        $organizacoes = (new Organizacao())->getALLOrganizacoes();
        $locais = (new Local())->getALLLocalizacao();

        $ataModel = new AtaModel();
        $ataModel->criarAta($organizacoes, $cursos, $nucleos, $cargos, $integrantes, $locais);
    }

    public function buscarAta()
    {
        $this->view->mostrarBuscaATA([
            'status' => 'aguardando',
            'mensagem' => 'Preencha os campos e gere uma nova ATA.'
        ]);
    }
}
?>