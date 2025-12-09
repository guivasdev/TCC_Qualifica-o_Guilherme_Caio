<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Model/classes/Documento.php';

require_once __DIR__ . "/../model/classes/Curso.php";
require_once __DIR__ . "/../model/classes/Integrante.php";
require_once __DIR__ . "/../model/classes/NucleoInstitucional.php";
require_once __DIR__ . "/../model/classes/Organizacao.php";
require_once __DIR__ . "/../model/classes/Local.php";


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
      
        $ata->data = $dados['data'] ?? '';
        // Conteúdo dividido: prefacio / introducao / assunto / encerramento
        $ata->prefacio = $dados['prefacio'] ?? ($dados['infoIntro'] ?? '');
        $ata->introducao = $dados['introducao'] ?? ($dados['infoIntro'] ?? '');
        $ata->assuntos = $dados['assuntos'] ?? ($dados['assunto'] ?? '');
        $ata->encerramento = $dados['encerramento'] ?? '';
        return $ata;
    }

    // -------------------------------------------------------
    //  Função dinâmica (corrigida)
    // -------------------------------------------------------
   private function obterValorCampo($campo, $modelo)
{
    $campoId = $_POST[$campo . '_id'] ?? null;
    $campoNovo = $_POST[$campo . '_novo'] ?? null;

    // Se veio o ID selecionado no dropdown
    if (!empty($campoId)) {
        return $campoId;
    }

    // Se o usuário digitou um novo valor
    if (!empty($campoNovo)) {
        // O $modelo deve ter um método para inserir e retornar o ID
        return $modelo->inserir($campoNovo);
    }

    // Nada selecionado
    return null;
}


    // =======================================================
    //  CRIAR ATA (CORRIGIDO)
    // =======================================================
   public function criarAta($organizacoes, $cursos, $nucleos, $cargos, $integrantes, $locais)
{
    if (ob_get_length()) {
        ob_end_clean();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Valores de selects ou inputs
      
        $organizacao = $this->obterValorCampo('organizacao', $organizacoes);
        $curso      = $this->obterValorCampo('curso', $cursos);
        $nucleo     = $this->obterValorCampo('nucleo', $nucleos);
        $integrantes = $this->obterValorCampo('integrante', $integrantes);
        $local       = $this->obterValorCampo('local', $locais);

        // Outros campos
        $nome = $_POST['nome'] ?? '';
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

        $doc = new Documento();
        $doc->cadastrarDocumento(
                $nome,
                $data, 
                $horaInicial, 
                $horaFinal, 
                $prefacio, 
                $infoIntro, 
                $assunto, 
                $encerramento, 
                $organizacao[0], 
                $nucleo[0], 
                $curso[0], 
                $local[0]
        );

        $org = new Organizacao();
        $nuc = new NucleoInstitucional();
        $cur = new Curso();
        $loc = new Local();
        $integr = new Integrante();

        $listIntegrantes = [];
        foreach ($integrantes as $i){
            $listIntegrantes = array_merge($listIntegrantes, $integr->getIntegrante($i, null));
        }
        
        $nomeOrg = $org->getOrganizacao($organizacao[0], null);
        $nomeNuc = $nuc->getNucleoInstitucional($nucleo[0], null);
        $nomecur = $cur->getCurso($curso[0], null);
        $nomeLoc = $loc->getLocalizacao($local[0], null);

        var_dump($integrantes);
        
        /*

        // ================================================
        //  GERAÇÃO DO PDF
        // ================================================
        $pdf = new MeuPDF();
        $pdf->SetFont('', '', 15);
        $pdf->setPrintFooter(true);
        $pdf->SetMargins(29, 40, 30);
        $pdf->AddPage();

        $pdf->Write(0, $nomeNuc["nome"] . " - " . $nomeNuc["sigla"]);
        $pdf->Ln(6);
        $pdf->Write(0, $nomecur["nome"]);
        $pdf->Ln(6);
        $pdf->Write(0, $nomeOrg["sigla"] . "|" . $nomeOrg["nome"]);
        $pdf->Ln(12);

        $pdf->Write(0, 'Data: ' . $textoData);
        $pdf->Ln(6);
        $pdf->Write(0, $nomeLoc["nome"]);
        $pdf->Ln(6);
        $pdf->Write(0, 'Horário: ' . $horaInicial . 'h às ' . $horaFinal . 'h.');
        $pdf->Ln(10);

        $style = '<style> p { text-align: justify; } </style>';

        $pdf->writeHTML($style . '<p>' . nl2br($infoIntro) . '</p>');
        $pdf->Ln(5);

        // Integrantes
        foreach ($listIntegrantes as $i) {

            $pdf->Write(0, $i["cargo_sigla"] . "." . $i["nome"] ." ______________________");
        }

        $pdf->Ln(20);// Espaço antes do prefácio valor anteriro 5, adicionado + 15, motiovo integrantes
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

        */

    } else {
        echo "<script>alert('Formulário não enviado corretamente.');</script>";
    }
        
}   
}
?>