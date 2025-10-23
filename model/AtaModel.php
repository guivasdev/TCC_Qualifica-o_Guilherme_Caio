<?php
require_once __DIR__ . '/../vendor/autoload.php';

class AtaModel
{
    public function criarAta()
    {
        return 'ata criada no teste model!';
    }

    public function buscarAta()
    {
        return 'ata buscada com sucesso no teste model!';
    }

    public function verificarCampos()
    {
        if (ob_get_length())
            ob_end_clean();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {


            $organizacao = $_POST['organizacao'] ?? "TESTANTO";
            $curso = $_POST['curso'] ?? "TESTANTO";
            $local = $_POST['local'] ?? "TESTANTO";
            $data = $_POST['data'] ?? "TESTANTO";
            $horario = $_POST['horario'] ?? "TESTANTO";
            $infoIntro = $_POST['infoIntro'] ?? "TESTANTO";
            $prefacio = $_POST['prefacio'] ?? "TESTANTO";
            $nucleo = $_POST['nucleo'] ?? "TESTANTO";
            $assunto = $_POST['assunto'] ?? "TESTANTO";
            $encerramento = $_POST['encerramento'] ?? "TESTANTO";
            $dataOriginal = $data; // formato: Y-m-d
$data2 = new DateTime($dataOriginal, new DateTimeZone('America/Sao_Paulo'));

            $fmt = new IntlDateFormatter(
                'pt_BR', // idioma
                IntlDateFormatter::LONG, // formato da data
                IntlDateFormatter::NONE, // sem hora
                'America/Sao_Paulo', // fuso horário
                IntlDateFormatter::GREGORIAN,
                "d 'de' MMMM 'de' y" // formato personalizado
            );
            $dataEncerramento = new IntlDateFormatter(
                'pt_BR', // idioma
                IntlDateFormatter::LONG, // formato da data
                IntlDateFormatter::NONE, // sem hora
                'America/Sao_Paulo', // fuso horário
                IntlDateFormatter::GREGORIAN,
                "dd / MM /yyyy" // formato personalizado
            );

            $novaData = $fmt->format($data2);
            $novaDataEncerramento = $dataEncerramento->format($data2);


            $pdf = new TCPDF();
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetMargins(20, 40, 20);
            $pdf->AddPage();
            $logo = __DIR__ . '/../Img/imgLogo.png';
            $pdf->Image($logo, 15, 20, 40, 0, '', '', '', false, 300, '', false, false, 0, false, false, false);

            $pdf->Write(0, $nucleo);
            $pdf->Ln(5);
            $pdf->Write(0, 'Curso:' . $curso);
            $pdf->Ln(5);
            $pdf->Write(0, $organizacao);
            $pdf->Ln(10);
            $pdf->Write(0, 'Data: ' . $novaData);
            $pdf->Ln(5);
            $pdf->Write(0, 'Local: ' . $local);
            $pdf->Ln(5);
            $pdf->Write(0, 'Horário: ' . $horario);
            $pdf->Ln(10);
            $pdf->Write(0, $infoIntro);
            $pdf->Ln(10);
            for ($i = 0; $i < 5; $i++) {
                $pdf->Write(0, "teste dos integrantes" . "______________________");
                $pdf->Ln(5);
            }


            $pdf->Ln(5);
            $pdf->Write(0, $prefacio);
            $pdf->Ln(10);
            $pdf->Write(0, $assunto);
            $pdf->Ln(15);
            $pdf->Write(0, $encerramento . " " . $novaDataEncerramento);

            $pdf->Output('arquivo.pdf', 'I');
            exit;

        } else {
            echo "<script>alert('Formulário não enviado corretamente.');</script>";

        }
    }

    public function integrantes()
    {


    }

}
$ata = new AtaModel();
$ata->verificarCampos();
?>