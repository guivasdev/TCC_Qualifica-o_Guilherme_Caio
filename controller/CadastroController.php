<?php

class CadastroController
{
    private Cadastro $model;
    private $formView;
    private $ataView;

    private array $tabelas = [
        'Organização' => 'organizacao',
        'Núcleo Institucional' => 'nucleo',
        'Curso' => 'curso',
        'Integrante' => 'integrante'
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
        $organizacoes = $this->model->buscarTodas('organizacao');
        $nucleos = $this->model->buscarTodas('nucleo');
        $cursos = $this->model->buscarTodas('curso');
        $cargos = $this->model->buscarTodas('cargo');

        $this->formView->mostrarFormularioUnico(
            $organizacoes,
            $nucleos,
            $cursos,
            $cargos
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

        $item = new CadastroItem($tabela, $dados);
        $resultado = $this->model->salvar($item);

        $_SESSION['mensagem'] = $resultado
            ? "✔ Registro salvo com sucesso!"
            : "✘ Erro ao salvar.";

        header("Location: index.php?acao=busca");
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
    public function mostrarPaginaAta($id)
    {
        $tabela = 'documento';

        // Se não recebeu ID → busca o último documento
        if ($id === null) {
            $ultimo = $this->model->buscarUltimoRegistro($tabela);

            if ($ultimo) {
                $id = $ultimo['id']; // pega o ID do último documento
            } else {
                // Nenhum documento → mostra página vazia
                $this->ataView->mostrarPaginaAta(null);
                return;
            }
        }

        // Carrega documento pelo ID
        $dados = $this->model->buscarPorId($tabela, $id);

        $this->ataView->mostrarPaginaAta($dados);
    }

    

}
