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
            'hora_inicial',
            'hora_final',
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

        $data['hora_inicial'] = preg_replace('/:00$/', '', $data['hora_inicial']);
        $data['hora_final'] = preg_replace('/:00$/', '', $data['hora_final']);
        return $data;
    }
}
?>