<?php
require_once __DIR__ . '/../model/AtaModel.php';

class AtaService
{
    private AtaModel $model;
    private AtaRepository $repo;


    public function __construct(AtaModel $model, AtaRepository $repo)
    {
        $this->model = $model;
        $this->repo = $repo;

    }

    public function criarAtaComValidacao(string $titulo, string $descricao): bool
    {
        if (empty($titulo) || empty($descricao)) {
            throw new InvalidArgumentException("Título e descrição são obrigatórios.");
        }
        return $this->model->criarAta($titulo, $descricao);
    }

    public function listarAtas(): array
    {
        return $this->model->listarAtas();
    }
    public function pesquisar(string $filtro, string $texto): ?Ata
    {
        return $this->repo->buscar($filtro, $texto);
    }
}
