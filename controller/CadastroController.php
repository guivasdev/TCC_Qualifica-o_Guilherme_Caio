<?php
require_once __DIR__ . '/../model/CadastroItem.php';

class CadastroController
{
    private Cadastro $model;
    private $formView;
    private $ataView;

    private array $tabelas = [
        'Organização' => 'organizacao',
        'Núcleo Institucional' => 'nucleo_institucional',
        'Curso' => 'curso',
        'Integrante' => 'integrante',
        'Local' => 'localizacao',
        'Cargo' => 'cargo',
    ];

    public function __construct(Cadastro $model, $formView, $ataView)
    {
        $this->model = $model;
        $this->formView = $formView;
        $this->ataView = $ataView;
    }

    // -----------------------------------------------
    // FORMULÁRIO ÚNICO
    // -----------------------------------------------
    public function mostrarFormularioUnico()
    {

        $organizacao = $this->model->buscarTodas('organizacao');
        $nucleos = $this->model->buscarTodas('nucleo_institucional');
        $cursos = $this->model->buscarTodas('curso');
        $cargos = $this->model->buscarTodas('cargo');
        $local = $this->model->buscarTodas('localizacao');
        $integrante = $this->model->buscarTodas('integrante');

        $this->formView->mostrarFormularioUnico(
            $organizacao,
            $nucleos,
            $cursos,
            $cargos,
            $local,
            $integrante
        );
    }

    // -----------------------------------------------
    // SALVAR REGISTRO
    // -----------------------------------------------
    public function salvarCadastro()
    {
        if (!isset($_POST['tabela'])) {
            echo "<p style='color:red'>Erro: tabela não definida!</p>";
            return;
        }

        $tabela = $_POST['tabela'];

        $dados = $_POST;
        unset($dados['tabela']);
        unset($dados['assunto']);

        try {
            $item = new CadastroItem($tabela, $dados);
            $resultado = $this->model->salvar($item);

            $_SESSION['mensagem'] = $resultado
                ? "✔ Registro salvo com sucesso!"
                : "✘ Erro ao salvar.";
        } catch (Exception $e) {
            $_SESSION['mensagem'] = "✘ Erro ao salvar: " . $e->getMessage();
        }

        header("Location: index.php?acao=buscar");
        exit;
    }

    // -----------------------------------------------
    // LISTAR REGISTROS
    // -----------------------------------------------
    public function mostrarBusca()
    {
        $tabela = $_GET['tabela'] ?? 'organizacao';
        $dados = $this->model->buscarTodas($tabela);

        $this->ataView->mostrarBuscaATA($dados, $tabela);
    }

public function mostrarPaginaAta($id = null, bool $buscarUltimoSeNulo = true)
{
    $tabela = 'documento';

    if ($id === null && $buscarUltimoSeNulo) {
        $ultimo = $this->model->buscarUltimoRegistro($tabela);
        $id = $ultimo ? (int) $ultimo['id'] : null;
    }

    if ($id === null) {
        // Nenhum documento encontrado ou ID não enviado
        $dados = []; // campos vazios
        $this->ataView->mostrarPaginaATA($dados);
        return;
    }

    // Busca os dados do documento
    $dados = $this->model->buscarPorId($tabela, $id);

    // Busca os IDs dos integrantes na tabela intermediária
    $resultado = $this->model->documento_integrante($id);
    $dados['integrantes'] = array_map(fn($item) => $item['integrante_id'], $resultado);

    // Chama a view passando os dados
    $this->ataView->mostrarPaginaATA($dados);
}

}
