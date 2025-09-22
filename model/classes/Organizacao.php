<?php 
    class Organizacao{
        private $nome ="";
        private $nucleoInstitucional = [];
        private $curso =[];
        private $integrantes = [];
  
        public function cadastrarOrganizacao($nome):int{}
        public function adicionarNucleo($nucleo): int{}
        public function adicionarCurso($curso):int{}
        public function adicionarIntegrantes($integrantes):int{}
        public function editarOrganizacao($organizacao):int{}
        public function excluirOrganizacao($confirmar, $organizacao): int{}
        
    }
?>