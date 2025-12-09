<?php
require_once __DIR__ . '/CadastroRepository.php';
require_once __DIR__ . '/CadastroItem.php';

class Cadastro
{
    private CadastroRepository $repo;

    public function __construct(CadastroRepository $repo)
    {
        $this->repo = $repo;
    }

    public function salvar(CadastroItem $item): bool
    {
        return $this->repo->salvar($item->tabela, $item->dados);
    }

    public function buscarTodas(string $tabela): array
    {
        return $this->repo->buscarTodas($tabela);
    }

    public function buscarPorId(string $tabela, int $id)
    {
        return $this->repo->buscarPorId($tabela, $id);
    }
    public function documento_integrante(int $documento_id): array
    {
             return $this->repo->documento_integrante($documento_id);
 }

    public function buscarUltimoRegistro(string $tabela)
    {
        return $this->repo->buscarUltimo($tabela);
    }
}
