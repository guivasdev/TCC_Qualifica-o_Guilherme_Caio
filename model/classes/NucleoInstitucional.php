<?php 
    class NucleoInstitucional{
        private $nome = "";
        private $integrantes = [];
        private $sigla ="";
        
        public function cadastrarNucleo($nome, $sigla): int{}
        public function adicionarIntegrante($integrantes): int{}
        public function editarNucleo($nucleo): int{}
        public function excluirNucleo($confirmar, $nucleo): int{}
        public function removerIntegrante($integrantes): int{}
        
    }
?>