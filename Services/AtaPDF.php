<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';



class MeuPDF extends TCPDF {
    public function Header() {
        $logo = __DIR__ . '/../Img/imgLogo.png';
        if (file_exists($logo)) {
            $this->Image($logo, 10, 10, 40);
        }
        $this->Ln(15);
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C');
    }

    public function gerar(Ata $ata): void {
        $this->AddPage();
        $this->SetFont('helvetica', '', 12);

        $html = "
        <h2 align='center'>ATA DE REUNIÃO</h2>
        <p><b>Organização:</b> {$ata->organizacao}</p>
        <p><b>Curso:</b> {$ata->curso}</p>
        <p><b>Núcleo:</b> {$ata->nucleo}</p>
        <p><b>Data:</b> {$ata->data}</p>
        <p><b>Horário:</b> {$ata->horaInicial} às {$ata->horaFinal}</p>
        <p><b>Local:</b> {$ata->local}</p>
        <br><h4>Informações:</h4>
        <p>{$ata->infoIntro}</p>
        <h4>Prefácio:</h4><p>{$ata->prefacio}</p>
        <h4>Assunto:</h4><p>{$ata->assunto}</p>
        <h4>Encerramento:</h4><p>{$ata->encerramento}</p>
        ";

        $this->writeHTML($html);
        $this->Output('ATA.pdf', 'I');
        exit;
    }
}
?>
