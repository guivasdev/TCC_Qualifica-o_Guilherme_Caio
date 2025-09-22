<?php 
    class Integrante{
        private $nome = "";
        private $cargo = "";

        public function cadastrarIntegrantes($nome): int{}
        public function atribuirCargo($cargo): int{}
        public function editarIntegrantes($integrantes): int{}

        public function excluirIntegrante($confirmar, $integrantes): int{}
        
    }
?>