<?php
    class Documento{
       public $nucleoInstitucional = "";
        public $curso = "";
        public $organizacao = "";
        public $data = "";
        public $local = "";
        public $hora = "";
        public $integrantes = "";
        public $introducao = "";
        public $assunto = "";
        public $encerramento = "";
        public $prefacio = "";

        public function gerarDocumento(): int{
            
        }

        public function salvarVersao($documento): int{

        }
        public function recuperarVersao($byteJson): int{

        }
    }
?>