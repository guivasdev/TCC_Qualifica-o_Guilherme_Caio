<?php
class Ata {
    public string $organizacao;
    public string $curso;
    public string $local;
    public string $data;
    public string $horaInicial;
    public string $horaFinal;
    public string $infoIntro;
    public string $prefacio;
    public string $nucleo;
    public string $assunto;
    public string $encerramento;

    public function __construct(array $dados) {
        foreach ($dados as $k => $v) {
            $this->$k = htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
        }
    }

    public function toArray(): array {
        return get_object_vars($this);
    }
}
?>
