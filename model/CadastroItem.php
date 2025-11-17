<?php

class CadastroItem
{
    public string $campo;
    public string $valor;

    public function __construct(string $campo, string $valor)
    {
        $this->campo = $campo;
        $this->valor = $valor;
    }
}
