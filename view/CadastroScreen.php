<?php

class CadastroScreen
{
    public function mostrarFormularioUnico($organizacao, $nucleos, $cursos, $cargos)
    {
        // Torna variáveis acessíveis dentro do criar.php
        $orgs = $organizacao;
        $nucs = $nucleos;
        $crs = $cursos;
        $cgs = $cargos;

        include __DIR__ . "/html/form.php";
    }

}