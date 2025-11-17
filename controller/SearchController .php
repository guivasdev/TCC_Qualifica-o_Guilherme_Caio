<?php

class SearchController {

    private AtaSearchService $service;

    public function __construct(AtaSearchService $service)
    {
        $this->service = $service;
    }

    public function handle(): void
    {
        $filtro   = $_GET['filtro']   ?? "";
        $pesquisa = $_GET['pesquisa'] ?? "";

        $ata = $this->service->pesquisar($filtro, $pesquisa);

        header("Content-Type: application/json");
        echo json_encode($ata);
    }
}
