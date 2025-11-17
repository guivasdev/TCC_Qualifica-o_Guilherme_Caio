<?php
class CadastroItem
{
    public string $tabela;
    public array $dados; // ← vários campos reais

    public function __construct(string $tabela, array $dados)
    {
        $this->tabela = $tabela;
        $this->dados  = $dados;
    }
}
