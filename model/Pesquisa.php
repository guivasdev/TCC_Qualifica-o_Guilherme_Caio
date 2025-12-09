<?php
require_once __DIR__ . '/MySql.php';


class Pesquisa
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = MySql::connect();
    }
    public function Pesquisar($filtro, $termo)
    {


        $sqlQuery = "SELECT d.*,
      o.id AS organizacao_id, o.nome AS organizacao_nome,
            n.id AS nucleo_id, n.nome AS nucleo_nome,
            c.id AS curso_id, c.nome AS curso_nome,
            l.nome AS local_nome,
       GROUP_CONCAT(DISTINCT i.id ORDER BY i.id SEPARATOR ', ') AS integrante_id,
       GROUP_CONCAT(DISTINCT i.nome ORDER BY i.nome SEPARATOR ', ') AS integrante_nome
FROM documento d
LEFT JOIN organizacao o ON d.organizacao_id = o.id
LEFT JOIN nucleo_institucional n ON d.nucleo_id = n.id
LEFT JOIN curso c ON d.curso_id = c.id
LEFT JOIN localizacao l ON d.local_id = l.id
LEFT JOIN documento_integrante di ON di.documento_id = d.id
LEFT JOIN integrante i ON i.id = di.integrante_id
GROUP BY d.id";

        // Mapeamento de colunas
        $colunas = [
            "nome" => "d.titulo",
            "titulo" => "d.titulo",
            "data" => "d.data",
            "prefacio" => "d.prefacio",
            "assunto" => "d.assunto",
            "conteudo" => "d.conteudo",
            "autor" => "integrante_nome"
        ];

        // Filtro dinâmico
        if ($filtro !== "tudo" && $filtro !== "recents" && isset($colunas[$filtro])) {
            $sqlQuery .= " HAVING " . $colunas[$filtro] . " LIKE :termo";
        }

        if ($filtro === "recents") {
            $sqlQuery .= " ORDER BY d.data DESC";
        } else {
            $sqlQuery .= " ORDER BY d.id DESC";
        }

        $sql =   $this->pdo->prepare($sqlQuery);

        if ($filtro !== "tudo" && isset($colunas[$filtro])) {
            $sql->bindValue(":termo", "%$termo%");
        }

        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
