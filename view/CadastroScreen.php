<?php

class CadastroScreen
{
    public function mostrarFormularioUnico($organizacoes, $nucleos, $cursos, $cargos)
    {
        // Torna variáveis acessíveis dentro do criar.php
        $orgs = $organizacoes;
        $nucs = $nucleos;
        $crs = $cursos;
        $cgs = $cargos;

        include __DIR__ . "/html/form.php";
    }

}