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

    // -----------------------------------------------
    // MOSTRAR ATA (POR ID OU ÚLTIMA)
    // -----------------------------------------------
    public function mostrarPaginaAta($id = null)
    {
        $tabela = 'documento';

        // Se não recebeu ID → busca o último documento
        if ($id === null) {
            $ultimo = $this->model->buscarUltimoRegistro($tabela);

            if ($ultimo) {
                $id = (int)$ultimo['id']; // pega o ID do último documento
            } else {
                // Nenhum documento → mostra página vazia
                $this->ataView->mostrarPaginaAta(null);
                return;
            }
        } else {
            // Cast para inteiro para garantir tipo
            $id = (int)$id;
        }

        // Carrega documento pelo ID
        $dados = $this->model->buscarPorId($tabela, $id);

        if ($dados) {
            // Retorna todos os dados do documento
            $this->ataView->mostrarPaginaAta($dados);
        } else {
            // Caso não encontre, mostra página vazia
            $this->ataView->mostrarPaginaAta(null);
        }
    }
    

}
