<?php
require_once __DIR__ . "/../model/AtaModel.php";
require_once __DIR__ . "/../model/OrganizacaoRepository.php";
require_once __DIR__ . "/../model/CursoRepository.php";
require_once __DIR__ . "/../model/NucleoRepository.php";
require_once __DIR__ . "/../model/CargoRepository.php";
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
        $orgRepo = new OrganizacaoRepository();
        $cursoRepo = new CursoRepository();
        $nucRepo = new NucleoRepository();
        $cargoRepo = new CargoRepository();

        // supondo que os repositórios tenham um método buscarTodas() ou similar
        $organizacoes = $orgRepo->buscarTodas();   // -> array [['id'=>..., 'nome'=>...], ...]
        $cursos = $cursoRepo->buscarTodas();
        $nucleos = $nucRepo->buscarTodas();
        $cargos = $cargoRepo->buscarTodas();

        // Chama criarAta passando os 4 arrays
        $this->model->criarAta($organizacoes, $cursos, $nucleos, $cargos);
        $resultado = $this->model->criarAta();
        $this->view->mostrarPaginaATA($resultado);
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