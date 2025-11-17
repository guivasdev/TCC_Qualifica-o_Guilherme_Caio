<?php

class Cadastro
{
    private CadastroRepository $repo;

    public function __construct(CadastroRepository $repo)
    {
        $this->repo = $repo;
    }

    public function salvar(array $dados)
    {
        return $this->repo->salvar($dados);
    }

    public function buscarTodas()
    {
        return $this->repo->buscarTodas();
    }

    public function buscarPorId($id)
    {
        return $this->repo->buscarPorId($id);
    }
}
