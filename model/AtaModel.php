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


            $organizacao = str_replace(array("\r", "\n"), ' ', $_POST['organizacao'] ?? "TESTANDO");
            $curso = str_replace(array("\r", "\n"), ' ', $_POST['curso'] ?? "TESTANDO");
            $local = str_replace(array("\r", "\n"), ' ', $_POST['local'] ?? "TESTANDO");
            $data = str_replace(array("\r", "\n"), ' ', $_POST['data'] ?? "TESTANDO");
            $horario = str_replace(array("\r", "\n"), ' ', $_POST['horario'] ?? "TESTANDO");
            $infoIntro = str_replace(array("\r", "\n"), ' ', $_POST['infoIntro'] ?? "TESTANDO");
            $prefacio = str_replace(array("\r", "\n"), ' ', $_POST['prefacio'] ?? "TESTANDO");
            $nucleo = str_replace(array("\r", "\n"), ' ', $_POST['nucleo'] ?? "TESTANDO");
            $assunto = str_replace(array("\r", "\n"), ' ', $_POST['assunto'] ?? "TESTANDO");
            $encerramento = str_replace(array("\r", "\n"), ' ', $_POST['encerramento'] ?? "TESTANDO");

            $dataOriginal = $data; // mantém o formato original
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
            $pdf->SetFont('', '', 14);

            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetMargins(29, 40, 30);
            $pdf->AddPage();
            $logo = __DIR__ . '/../Img/imgLogo.png';
            // Pega as dimensões originais em pixels
            list($width, $height) = getimagesize($logo);

            // Converte pixels para milímetros (1px = 0.264583 mm)
            $width_mm = $width * 0.264583;
            $height_mm = $height * 0.264583;

            // Fator de aumento (por exemplo, 1.5x maior)
            $escala = 0.7;

            $pdf->Image(
                $logo,          // caminho da imagem
                5,             // posição X
                5,             // posição Y
                $width_mm * $escala,  // nova largura (maior)
                $height_mm * $escala, // nova altura (proporcional)
                '',
                '',
                '',
                false,
                10000,            // 600 DPI garante alta qualidade
                '',
                false,
                false,
                0,
                false,
                false,
                false
            );

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