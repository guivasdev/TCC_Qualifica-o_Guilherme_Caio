<?php
class Ata {
    public ?int $id = null;
    public string $titulo = '';
    public string $organizacao = '';
    public string $curso = '';
    public string $local = '';
    public string $nucleo = '';

    // Datas / horários (aceita camelCase e snake_case)
    public ?string $data = null;
    public ?string $horaInicial = null;
    public ?string $horaFinal = null;
    public ?string $hora_inicial = null;
    public ?string $hora_final = null;

    // Conteúdo dividido
    public string $prefacio = '';
    public string $introducao = '';
    public string $infoIntro = '';
    public string $assuntos = '';
    public string $assunto = '';
    public string $encerramento = '';

    // Meta / corpo
    public string $conteudo = '';

    // Relacionamentos
    // Legacy names (kept for backward compatibility)
    public ?int $fk_organizacao_id = null;
    public ?int $fk_nucleo_id = null;
    public ?int $fk_curso_id = null;
    public ?int $fk_localizacao_id = null;
    public ?int $fk_integrantes_id = null;

    // Preferred / normalized names (match `documento` schema)
    public ?int $organizacao_id = null;
    public ?int $nucleo_id = null;
    public ?int $curso_id = null;
    public ?int $local_id = null;
    public ?int $integrante_id = null;
    // normalized predefinicao id (preferred) and legacy alias
    public ?int $predefinicao_id = null;
    public ?int $fk_predefinicao_id = null;

    public array $integrantes = [];

    public function __construct(array $dados = []) {
        foreach ($dados as $k => $v) {
            // normaliza chaves comuns (ex.: infoIntro vs introducao)
            $key = $k;
            // map legacy fk_ fields to normalized names
            if ($k === 'fk_organizacao_id') { $this->fk_organizacao_id = (int)$v; $this->organizacao_id = (int)$v; continue; }
            if ($k === 'fk_nucleo_id') { $this->fk_nucleo_id = (int)$v; $this->nucleo_id = (int)$v; continue; }
            if ($k === 'fk_curso_id') { $this->fk_curso_id = (int)$v; $this->curso_id = (int)$v; continue; }
            if ($k === 'fk_localizacao_id') { $this->fk_localizacao_id = (int)$v; $this->local_id = (int)$v; continue; }
            if ($k === 'fk_integrantes_id') { $this->fk_integrantes_id = (int)$v; $this->integrante_id = (int)$v; continue; }
            if ($k === 'organizacao_id') { $this->organizacao_id = (int)$v; $this->fk_organizacao_id = (int)$v; }
            if ($k === 'nucleo_id') { $this->nucleo_id = (int)$v; $this->fk_nucleo_id = (int)$v; }
            if ($k === 'curso_id') { $this->curso_id = (int)$v; $this->fk_curso_id = (int)$v; }
            if ($k === 'local_id') { $this->local_id = (int)$v; $this->fk_localizacao_id = (int)$v; }
            if ($k === 'integrante_id') { $this->integrante_id = (int)$v; $this->fk_integrantes_id = (int)$v; }
            if ($k === 'fk_predefinicao_id' || $k === 'predefinicao_id') { $this->predefinicao_id = (int)$v; $this->fk_predefinicao_id = (int)$v; continue; }
            switch ($k) {
                case 'infoIntro': $key = 'infoIntro'; break;
                case 'introducao': $key = 'introducao'; break;
                case 'hora_inicial': $key = 'hora_inicial'; break;
            }
            $this->$key = htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
            // manter também versões alternativas
            if ($key === 'hora_inicial') $this->horaInicial = $this->hora_inicial;
            if ($key === 'hora_final') $this->horaFinal = $this->hora_final;
            if ($key === 'introducao' && empty($this->infoIntro)) $this->infoIntro = $this->introducao;
            if ($key === 'infoIntro' && empty($this->introducao)) $this->introducao = $this->infoIntro;
            if ($key === 'assunto' && empty($this->assuntos)) $this->assuntos = $this->assunto;
            if ($key === 'assuntos' && empty($this->assunto)) $this->assunto = $this->assuntos;
        }
    }

    public function toArray(): array {
        return get_object_vars($this);
    }
}
?>
