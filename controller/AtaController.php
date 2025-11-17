<?php
require_once __DIR__ . '/../model/OrganizacaoRepository.php';
require_once __DIR__ . '/../model/CadastroRepository.php';
require_once __DIR__ . '/../model/AtaRepository.php';
require_once __DIR__ . '/../model/CargoRepository.php';
require_once __DIR__ . '/../model/CursoRepository.php';
require_once __DIR__ . '/../model/NucleoRepository.php';


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
        $organizacoes = (new OrganizacaoRepository())->buscarTodas();
        $cursos = (new CursoRepository())->buscarTodas();
        $nucleos = (new NucleoRepository())->buscarTodas();
        $cargos = (new CargoRepository())->buscarTodas();

        $ataModel = new AtaModel();
        $ataModel->criarAta($organizacoes, $cursos, $nucleos, $cargos);
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