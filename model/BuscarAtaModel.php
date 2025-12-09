<?php 
    class BuscarAtaModel{

        public function buscarAtas(){
            require_once __DIR__ . '/../model/classes/Pesquisa.php';
            $Busca = new Pesquisa();
            return $Busca->Pesquisar();
        }
    }
?>