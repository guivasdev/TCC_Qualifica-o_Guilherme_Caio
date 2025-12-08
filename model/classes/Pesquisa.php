<?php
    include 'Documento.php';
    class Pesquisa{
        public $documento = new Documento();

        public function Pesquisar(): Documento{
            require_once __DIR__ . '/../MySQL.php';
            $pdo = MySQL::conectar();

            $sql = $pdo->prepare("SELECT d.*, o.id   AS organizacao_id, o.nome AS organizacao_nome, n.id   AS nucleo_id, n.nome AS nucleo_nome, c.id   AS curso_id, c.nome AS curso_nome, l.id   AS local_id, l.nome AS local_nome, i.id   AS integrante_id, i.nome AS integrante_nome 
            FROM documento d
            LEFT JOIN organizacao o ON d.organizacao_id = o.id
            LEFT JOIN nucleo_institucional n ON d.nucleo_id = n.id
            LEFT JOIN curso c ON d.curso_id = c.id
            LEFT JOIN localizacao l ON d.local_id = l.id
            LEFT JOIN documento_integrante di ON di.documento_id = d.id
            LEFT JOIN integrante i ON i.id = di.integrante_id");

        }
    }
?>