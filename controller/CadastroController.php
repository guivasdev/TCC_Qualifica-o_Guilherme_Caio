<?php

class CadastroController
{
    private Cadastro $model;
    private $formView; // view do formulário
    private $ataView;  // view da busca
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

    // Mostra formulário de cadastro

    public function mostrarFormularioUnico()
    {
        // Buscar todos os dados necessários
        $organizacoes = $this->model->buscarTodas('organizacao');
        $nucleos = $this->model->buscarTodas('nucleo');
        $cursos = $this->model->buscarTodas('curso');
        $cargos = $this->model->buscarTodas('cargo');

        // Passa tudo para a view
        $this->formView->mostrarFormularioUnico($organizacoes, $nucleos, $cursos, $cargos);
    }

    // Salva cadastro dinâmico
    public function salvarCadastro()
    {
        if (!isset($_POST['tabela'])) {
            echo "<p style='color:red'>Erro: tabela não definida!</p>";
            return;
        }

        $tabela = $_POST['tabela'];

        // Remove campo tabela para não inserir no banco
        $dados = $_POST;
        unset($dados['tabela']);


        $item = new CadastroItem($_POST['tabela'], $dados);
        $resultado = $this->model->salvar($item);

        if ($resultado) {
            $_SESSION['mensagem'] = "✔ Registro salvo com sucesso!";
        } else {
            $_SESSION['mensagem'] = "✘ Erro ao salvar.";
        }
        header("Location: index.php?acao=busca");
        exit;

    }

    // Mostra todos os registros
    public function mostrarBusca()
    {
        // Se quiser, pode passar a tabela como parâmetro
        $tabela = $_GET['tabela'] ?? 'organizacao';
        $resultado = $this->model->buscarTodas($tabela);
        $this->ataView->mostrarBuscaATA($resultado, $tabela);
    }

    // Mostra página de registro específico
    public function mostrarPaginaAta($id, $tabela = 'organizacao')
    {
        $resultado = $this->model->buscarPorId($id, $tabela);
        $this->ataView->mostrarPaginaATA($resultado);
    }

}
