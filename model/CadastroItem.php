<?php

class CadastroItem
{
    public string $tabela;
    public array $dados;

    public function __construct(string $tabela, array $dados)
    {
        $this->tabela = $tabela;
        $this->dados  = $this->processarDados($dados);
    }

    private function processarDados(array $dados): array
    {
        $limpos = [];

        foreach ($dados as $campo => $valor) {

            // ignora campo vazio
            if ($valor === '' || $valor === null) {
                continue;
            }

            // Remove quebras de linha
            if (is_string($valor)) {
                $valor = str_replace(["\r", "\n"], ' ', $valor);
            }

            // trata pares *_id e *_novo
            if (str_ends_with($campo, '_id')) {

                $prefixo = substr($campo, 0, -3); // remove "_id"
                $campo_novo = $prefixo . '_novo';

                // se o usuário preencheu o novo → salva esse e ignora o ID
                if (!empty($dados[$campo_novo])) {
                    $limpos[$prefixo] = str_replace(["\r", "\n"], ' ', $dados[$campo_novo]);
                    continue;
                }

                // caso contrário, salva só o ID mesmo
                $limpos[$campo] = $valor;
                continue;
            }

            // ignora *_novo (já tratados acima)
            if (str_ends_with($campo, '_novo')) {
                continue;
            }

            // campos comuns normais
            $limpos[$campo] = $valor;
        }

        return $limpos;
    }
}
