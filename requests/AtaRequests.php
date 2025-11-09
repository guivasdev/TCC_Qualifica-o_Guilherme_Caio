<?php
class AtaRequest
{
    public function getData(): array
    {
        $fields = [
            'organizacao',
            'curso',
            'local',
            'data',
            'horaInicial',
            'horaFinal',
            'infoIntro',
            'prefacio',
            'nucleo',
            'assunto',
            'encerramento'
        ];

        $data = [];
        foreach ($fields as $field) {
            $value = $_POST[$field] ?? 'TESTANDO';
            $data[$field] = str_replace(["\r", "\n"], ' ', $value);
        }

        $data['horaInicial'] = preg_replace('/:00$/', '', $data['horaInicial']);
        $data['horaFinal'] = preg_replace('/:00$/', '', $data['horaFinal']);
        return $data;
    }
}
?>