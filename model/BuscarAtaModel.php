<?php 
    require_once __DIR__ . '/../model/classes/Pesquisa.php';

    class BuscarAtaModel{

        public function buscarAtas(){
            $Busca = new Pesquisa();
            
            return $Busca->Pesquisar();
        }
    }
?>