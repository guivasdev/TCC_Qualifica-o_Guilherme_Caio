<?php
require_once __DIR__ . '/../vendor/autoload.php';

class AtaModel
{
    public function criarAta() {
    // ... todo o código que estava em verificarCampos()

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

            $data2 = new DateTime($data, new DateTimeZone('America/Sao_Paulo'));

            $fmt = new IntlDateFormatter(
                'pt_BR',
                IntlDateFormatter::LONG,
                IntlDateFormatter::NONE,
                'America/Sao_Paulo',
                IntlDateFormatter::GREGORIAN,
                "d 'de' MMMM 'de' y"
            );

            $dataEncerramento = new IntlDateFormatter(
                'pt_BR',
                IntlDateFormatter::LONG,
                IntlDateFormatter::NONE,
                'America/Sao_Paulo',
                IntlDateFormatter::GREGORIAN,
                "dd / MM / yyyy"
            );

            $novaData = $fmt->format($data2);
            $novaDataEncerramento = $dataEncerramento->format($data2);

            $pdf = new TCPDF();
            $pdf->SetFont('', '', 15);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetMargins(29, 40, 30);
            $pdf->AddPage();

            $logo = __DIR__ . '/../Img/imgLogo.png';
            list($width, $height) = getimagesize($logo);
            $width_mm = $width * 0.264583;
            $height_mm = $height * 0.264583;
            $escala = 0.7;

            $pdf->Image($logo, 5, 5, $width_mm * $escala, $height_mm * $escala, '', '', '', false, 600);

            // Cabeçalho e dados básicos
            $pdf->Write(0, $nucleo);
            $pdf->Ln(5);
            $pdf->Write(0, $curso);
            $pdf->Ln(5);
            $pdf->Write(0, $organizacao);
            $pdf->Ln(10);
            $pdf->Write(0, 'Data: ' . $novaData);
            $pdf->Ln(5);
            $pdf->Write(0, 'Local: ' . $local);
            $pdf->Ln(5);
            $pdf->Write(0, 'Horário: ' . $horario);
            $pdf->Ln(10);

            // --- CSS global para os textos formatados ---
            $style = '
                <style>
                    p { text-align: justify; }
                </style>
            ';

            // --- infoIntro (HTML estilizado) ---
            $htmlIntro = $style . '<p>' . nl2br($infoIntro) . '</p>';
            $pdf->writeHTML($htmlIntro, true, false, true, false, '');
            $pdf->Ln(10);

            // --- lista de integrantes (sem CSS, texto puro) ---
            for ($i = 0; $i < 5; $i++) {
                $pdf->Write(0, "teste dos integrantes ______________________");
                $pdf->Ln(5);
            }
            $pdf->Ln(5);

            // --- prefacio (HTML estilizado) ---
            $htmlPrefacio = $style . '<p>' . nl2br($prefacio) . '</p>';
            $pdf->writeHTML($htmlPrefacio, true, false, true, false, '');
            $pdf->Ln(10);

            // --- assunto (HTML estilizado) ---
            $htmlAssunto = $style . '<p>' . nl2br($assunto) . '</p>';
            $pdf->writeHTML($htmlAssunto, true, false, true, false, '');
            $pdf->Ln(10);

            // --- encerramento (HTML estilizado + data) ---
            $htmlEncerramento = $style . '<p>' . nl2br($encerramento) . ' — ' . $novaDataEncerramento . '</p>';
            $pdf->writeHTML($htmlEncerramento, true, false, true, false, '');
            
            $pdf->Output('arquivo.pdf', 'I');
            exit;

        } else {
            echo "<script>alert('Formulário não enviado corretamente.');</script>";
        }
    }
}

$ata = new AtaModel();
$ata->criarAta();
?>