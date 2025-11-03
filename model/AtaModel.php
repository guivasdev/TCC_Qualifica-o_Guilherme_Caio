<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Classe personalizada herdando de TCPDF
class MeuPDF extends TCPDF
{
    // Cabeçalho (executa em todas as páginas)
    public function Header()
    {
        $logo = __DIR__ . '/../Img/imgLogo.png';
        if (file_exists($logo)) {
            list($width, $height) = getimagesize($logo);
            $width_mm = $width * 0.264583;
            $height_mm = $height * 0.264583;
            $escala = 0.7;

            $this->Image($logo, 5, 5, $width_mm * $escala, $height_mm * $escala, '', '', '', false, 300);
        }

        // Define margem após o cabeçalho
        $this->SetY(25);
    }

    // Rodapé (executa em todas as páginas)
   public function Footer()
{
    // Altura do rodapé
    $footerHeight = 20;

    // Define posição Y (altura da página - rodapé)
    $this->SetY(-$footerHeight);

    // Largura e altura da página
    $pageWidth = $this->getPageWidth();
    $pageHeight = $this->getPageHeight();

    // Define cor e fonte do texto
    $this->SetTextColor(95, 155, 167) ;// Branco
    $this->SetFont('helvetica', '', 13);

    // Texto da esquerda
    $leftText = "FHO Uniararas\nAv. Dr. Maximiliano Baruto, 500\nJd. Universitário - Araras/SP\nCEP: 13607-339";

    // Texto da direita
    $rightText = "www.uniararas.br";

    // Define a posição do texto esquerdo
    $this->SetXY(7, $pageHeight - $footerHeight -10);
    $this->MultiCell(0, 4, $leftText, 0, 'L', false, 1, '', '', true);

    // Define a posição do texto direito (domínio)
    $this->SetXY(-40, $pageHeight - $footerHeight +2);
    $this->Cell(0, 0, $rightText, 0, 0, 'R', false, '', 0, false, 'T', 'M');
}

}

class AtaModel
{
    public function criarAta()
    {
        if (ob_get_length())
            ob_end_clean();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // --- Coleta e limpeza dos dados do POST ---
            $organizacao = str_replace(["\r", "\n"], ' ', $_POST['organizacao'] ?? "TESTANDO");
            $curso = str_replace(["\r", "\n"], ' ', $_POST['curso'] ?? "TESTANDO");
            $local = str_replace(["\r", "\n"], ' ', $_POST['local'] ?? "TESTANDO");
            $data = str_replace(["\r", "\n"], ' ', $_POST['data'] ?? "TESTANDO");
            $horarioInicio = str_replace(["\r", "\n"], ' ', $_POST['horaInicial'] ?? "TESTANDO");
            $horarioFinal = str_replace(["\r", "\n"], ' ', $_POST['horaFinal'] ?? "TESTANDO");
            $infoIntro = str_replace(["\r", "\n"], ' ', $_POST['infoIntro'] ?? "TESTANDO");
            $prefacio = str_replace(["\r", "\n"], ' ', $_POST['prefacio'] ?? "TESTANDO");
            $nucleo = str_replace(["\r", "\n"], ' ', $_POST['nucleo'] ?? "TESTANDO");
            $assunto = str_replace(["\r", "\n"], ' ', $_POST['assunto'] ?? "TESTANDO");
            $encerramento = str_replace(["\r", "\n"], ' ', $_POST['encerramento'] ?? "TESTANDO");

            // --- Formatação de datas ---
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

            // --- Criação do PDF com a classe personalizada ---
            $pdf = new MeuPDF();
            $pdf->SetFont('', '', 15);
            $pdf->setPrintFooter(true);
            $pdf->SetMargins(29, 40, 30);
            $pdf->AddPage();

            // --- Cabeçalho e dados principais ---
            $pdf->Write(0, $nucleo);
            $pdf->Ln(6);
            $pdf->Write(0, $curso);
            $pdf->Ln(6);
            $pdf->Write(0, $organizacao);
            $pdf->Ln(12);

            $pdf->Write(0, 'Data: ' . $novaData);
            $pdf->Ln(6);
            $pdf->Write(0, 'Local: ' . $local);
            $pdf->Ln(6);
            $pdf->Write(0, 'Horário: ' . $horarioInicio . 'h às ' . $horarioFinal . 'h.');
            $pdf->Ln(10);

            // --- Estilo global ---
            $style = '
                <style>
                    p { text-align: justify; }
                </style>
            ';

            // --- infoIntro ---
            $htmlIntro = $style . '<p>' . nl2br($infoIntro) . '</p>';
            $pdf->writeHTML($htmlIntro, true, false, true, false, '');
            $pdf->Ln(10);

            // --- lista de integrantes ---
            for ($i = 0; $i < 5; $i++) {
                $pdf->Write(0, "teste dos integrantes ______________________");
                $pdf->Ln(5);
            }
            $pdf->Ln(5);

            // --- prefacio ---
            $htmlPrefacio = $style . '<p>' . nl2br($prefacio) . '</p>';
            $pdf->writeHTML($htmlPrefacio, true, false, true, false, '');
            $pdf->Ln(10);

            // --- assunto ---
            $htmlAssunto = $style . '<p>' . nl2br($assunto) . '</p>';
            $pdf->writeHTML($htmlAssunto, true, false, true, false, '');
            $pdf->Ln(10);

            // --- encerramento ---
            $htmlEncerramento = $style . '<p>' . nl2br($encerramento) . '</p>';
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
