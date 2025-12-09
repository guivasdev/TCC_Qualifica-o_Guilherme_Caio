<?php

class CadastroScreen
{
    public function mostrarFormularioUnico($organizacao, $nucleo, $curso, $cargo)
    {
        // Torna variáveis acessíveis dentro do form.php
        $organizacoes = $organizacao;
        $nucleos = $nucleo;
        $cursos = $curso;
        $cargos = $cargo;

        include __DIR__ . "/html/form.php";
    }

}