<?php

class AtaData
{
    public function __construct(public array $data)
    {
    }

    public function dataFormatada(): string
    {
        $dt = new DateTime($this->data['data'], new DateTimeZone('America/Sao_Paulo'));
        $fmt = new IntlDateFormatter(
            'pt_BR',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE,
            'America/Sao_Paulo',
            IntlDateFormatter::GREGORIAN,
            "d 'de' MMMM 'de' y"
        );
        $novaData = $fmt->format($dt);
        return preg_replace_callback("/de (\p{L}+)/u", fn($m) => "de " . ucfirst($m[1]), $novaData);
    }
}
?>