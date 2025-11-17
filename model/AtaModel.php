<?php
require_once __DIR__ . '/../vendor/autoload.php';

// =======================================================
//  Classe personalizada TCPDF
// =======================================================
class MeuPDF extends TCPDF
{
    public function Header()
    {
        $logo = __DIR__ . '/../Img/imgLogo.png';

        if (file_exists($logo)) {
            list($width, $height) = getimagesize($logo);
            $width_mm = $width * 0.264583;
            $height_mm = $height * 0.264583;

            $this->Image($logo, 5, 5, $width_mm * 0.7, $height_mm * 0.7, '', '', '', false, 300);
        }

        $this->SetY(25);
    }

    public function Footer()
    {
        $footerHeight = 20;
        $this->SetY(-$footerHeight);

        $pageWidth = $this->getPageWidth();
        $pageHeight = $this->getPageHeight();

        $this->SetTextColor(95, 155, 167);
        $this->SetFont('helvetica', '', 13);

        $leftText = "FHO Uniararas\nAv. Dr. Maximiliano Baruto, 500\nJd. Universitário - Araras/SP\nCEP: 13607-339";
        $rightText = "www.uniararas.br";

        $this->SetXY(7, $pageHeight - $footerHeight - 10);
        $this->MultiCell(0, 4, $leftText, 0, 'L', false, 1, '', '', true);

        $this->SetXY(-40, $pageHeight - $footerHeight + 2);
        $this->Cell(0, 0, $rightText, 0, 0, 'R');
    }
}


// =======================================================
//  AtaModel
// =======================================================
class AtaModel
{
    public static function fromArray(array $dados): Ata
    {
        $ata = new Ata();
        $ata->id = $dados['id'] ?? null;
        $ata->titulo = $dados['titulo'] ?? '';
        $ata->data = $dados['data'] ?? '';
        $ata->tipo = $dados['tipo'] ?? '';
        $ata->assuntos = $dados['assuntos'] ?? '';
        $ata->palavras_chave = $dados['palavras_chave'] ?? '';
        $ata->resumo = $dados['resumo'] ?? '';
        return $ata;
    }

    // -------------------------------------------------------
    //  Função dinâmica (corrigida)
    // -------------------------------------------------------
    function obterValorCampo($campo, $opcoes)
    {
        $novo = trim($_POST["{$campo}_novo"] ?? '');
        $id = $_POST["{$campo}_id"] ?? '';

        if ($novo !== '') {
            return str_replace(["\r", "\n"], ' ', $novo);
        }

        if ($id !== '') {
            foreach ($opcoes as $op) {
                if ($op['id'] == $id) {
                    return str_replace(["\r", "\n"], ' ', $op['nome']);
                }
            }
        }

        return "";
    }

    // =======================================================
    //  CRIAR ATA (CORRIGIDO)
    // =======================================================
    public function criarAta($organizacoes, $cursos, $nucleos, $cargos)
{
    if (ob_get_length()) {
        ob_end_clean();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Valores de selects ou inputs
        $organizacao = $this->obterValorCampo('organizacao', $organizacoes);
        $curso = $this->obterValorCampo('curso', $cursos);
        $nucleo = $this->obterValorCampo('nucleo', $nucleos);
        $cargo = $this->obterValorCampo('cargo', $cargos);

        // Outros campos
        $local = $_POST['local'] ?? '';
        $data = $_POST['data'] ?? '';
        $horaInicial = $_POST['hora_inicial'] ?? '';
        $horaFinal = $_POST['hora_final'] ?? '';

        $infoIntro = $_POST['infoIntro'] ?? '';
        $prefacio = $_POST['prefacio'] ?? '';
        $assunto = $_POST['assunto'] ?? '';
        $encerramento = $_POST['encerramento'] ?? '';

        // Limpar quebras de linha
        foreach (['local', 'data', 'horaInicial', 'horaFinal', 'infoIntro', 'prefacio', 'assunto', 'encerramento'] as $c) {
            ${$c} = str_replace(["\r", "\n"], ' ', ${$c});
        }

        // Remover :00 do horário
        $horaInicial = preg_replace('/:00$/', '', $horaInicial);
        $horaFinal = preg_replace('/:00$/', '', $horaFinal);

        // Formatar data
        try {
            $dataObj = new DateTime($data, new DateTimeZone('America/Sao_Paulo'));
        } catch (Exception $e) {
            $dataObj = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        }

        $fmt = new IntlDateFormatter(
            'pt_BR',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE,
            'America/Sao_Paulo',
            IntlDateFormatter::GREGORIAN,
            "d 'de' MMMM 'de' y"
        );

        $novaData = $fmt->format($dataObj);
        $textoData = preg_replace_callback(
            "/de (\p{L}+)/u",
            fn($m) => "de " . ucfirst($m[1]),
            $novaData
        );

        // ================================================
        //  GERAÇÃO DO PDF
        // ================================================
        $pdf = new MeuPDF();
        $pdf->SetFont('', '', 15);
        $pdf->setPrintFooter(true);
        $pdf->SetMargins(29, 40, 30);
        $pdf->AddPage();

        $pdf->Write(0, $nucleo);
        $pdf->Ln(6);
        $pdf->Write(0, $curso);
        $pdf->Ln(6);
        $pdf->Write(0, $organizacao);
        $pdf->Ln(12);

        $pdf->Write(0, 'Data: ' . $textoData);
        $pdf->Ln(6);
        $pdf->Write(0, 'Local: ' . $local);
        $pdf->Ln(6);
        $pdf->Write(0, 'Horário: ' . $horaInicial . 'h às ' . $horaFinal . 'h.');
        $pdf->Ln(10);

        $style = '<style> p { text-align: justify; } </style>';

        $pdf->writeHTML($style . '<p>' . nl2br($infoIntro) . '</p>');
        $pdf->Ln(5);

        for ($i = 0; $i < 5; $i++) {
            $pdf->Write(0, "teste dos integrantes ______________________");
            $pdf->Ln(5);
        }

        $pdf->Ln(5);
        $pdf->writeHTML($style . '<p>' . nl2br($prefacio) . '</p>');
        $pdf->Ln(10);

        $pdf->writeHTML($style . '<p>' . nl2br($assunto) . '</p>');
        $pdf->Ln(5);

        $pdf->writeHTML($style . '<p>' . nl2br($encerramento) . '</p>');

        // Limpa buffer e envia PDF
        if (ob_get_length()) {
            ob_end_clean();
        }
        $pdf->Output('arquivo.pdf', 'I');
        exit;

    } else {
        echo "<script>alert('Formulário não enviado corretamente.');</script>";
    }
}

}
?>