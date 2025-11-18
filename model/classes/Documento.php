<?php
    class Documento{
        public $nome = "";
        public $nucleoInstitucional = "";
        public $curso = "";
        public $organizacao = "";
        public $data = "";
        public $horas = "";
        public $local = "";
        public $hora = "";
        public $integrantes = [];
        public $introducao = "";
        public $assunto = "";
        public $encerramento = "";
        public $prefacio = "";

        /*
        public function getComponentes($n, $c, $o, $d, $l, $h, $i, $in, $a, $e, $p){
           
            $this->nucleoInstitucional = $n;
            $this->curso = $c;
            $this->organizacao = $o;
            $this->data = $d;
            $this->local = $l;
            $this->hora = $h;
            $this->integrantes = $i;
            $this->introducao = $in;
            $this->assunto = $a;
            $this->encerramento = $e;
            $this->prefacio = $p;
        }
        */

        public function gerarDocumento(): int{ #Geração do documento
            
        }

        public function salvarVersao($documento): int{ #Versionamento

        }
        public function recuperarVersao($byteJson): int{ #Versionamento

        }

        public function getDocumento($id, $nome){ #banco de dados

            require_once 'model/MySql.php';
            $documentoPDO = new MySql;

            $sql = "SELECT * FROM Documentos WHERE id = '$id' OR nome = '$nome'";

            if ($sql = $documentoPDO->query($sql)) {
                
                return $sql->fetchAll(PDO::FETCH_ASSOC);

            }else {
            
                return 0;
            }
        }

        public function getALLDocumentos(){ #banco de dados

            require_once 'model/MySql.php';
            $documentoPDO = new MySql;

            $sql = "SELECT * FROM Documentos";

            if ($sql = $documentoPDO->query($sql)) {
                
                return $sql->fetchAll(PDO::FETCH_ASSOC);

            }else {
            
                return 0;
            }
        }

        public function cadastrarDocumento($nome, $idOrganização, $idNucleo, $idCurso, $idLocalizacao, $idIntegrantes, $data, $hora, $prefacio, $introducao, $assunto, $encerramento){ #banco de dados
            
            require_once 'model/MySql.php';
            $documentoPDO = new MySql;

            $sql = "INSERT INTO Documentos SET Nome = '$nome', fk_Organizacoes_Id = '$idOrganização', fk_Nucleos_Institucionais_Id = '$idNucleo', fk_Curso_Id = '$idCurso' fk_Localizacao_Id = '$idLocalizacao', fk_Integrantes_Id = '$idIntegrantes', Dia = '$data', Hora = '$hora', Prefacio = '$prefacio', Introducao' = $introducao', Assunto = '$assunto', Encerramento = '$encerramento' ";

            if ($sql = $documentoPDO->query($sql)) {
                
                // Cadastro realizado com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0; URL=vendas.php'>
                    <script type=\"text/javascript\">
                        alert(\"Documento cadastrada com sucesso!\");
                    </script>
                    ";

                return 1;
            } else {
            
                // Caso ocorra falha
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0; URL=vendas.php'>
                        <script type=\"text/javascript\">
                            alert(\"Erro durante o cadastro.\");
                        </script>
                    ";

                return 0;
            }
        }

        public function EditarDocumento($id, $nome, $idOrganização, $idNucleo, $idCurso, $idLocalizacao, $idIntegrantes, $data, $hora, $prefacio, $introducao, $assunto, $encerramento){ #banco de dados

            require_once 'model/MySql.php';
            $documentoPDO = new MySql;

            $sql = "UPDATE Documentos SET Nome = '$nome', fk_Organizacoes_Id = '$organizacao', fk_Nucleos_Institucionais_Id = '$nucleoInstitucional', fk_Curso_Id = '$curso' fk_Localizacao_Id = '$local', fk_Integrantes_Id = '$integrantes', Dia = '$data', Hora = '$horas', Prefacio = '$prefacio', Introducao' = $introducao', Assunto = '$assunto', Encerramento = '$encerramento' WHERE id = '$id' ";

            if ($sql = $documentoPDO->query($sql)) {
                
                // Edição realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Documento editado com sucesso!\");
                    </script>
                    ";

                return 1;
            } else {
            
                // Caso ocorra falha
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;
                        <script type=\"text/javascript\">
                            alert(\"Erro durante a edição.\");
                        </script>
                    ";

                return 0;
            }
        }

        public function excluirDocumento($id): int{ #banco de dados

            require_once 'model/MySql.php';
            $documentoPDO = new MySql;

            $sql = "DELETE FROM Documentos WHERE id = '$id'"; #incluir desição para excluir, javascript alert ou um modal com botões?

            if ($sql = $documentoPDO->query($sql)) {
                
                // Exclusão realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Documento excluído com sucesso!\");
                    </script>
                    ";

                return 1;
            } else {
            
                // Caso ocorra falha
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;
                        <script type=\"text/javascript\">
                            alert(\"Erro durante a exclusão.\");
                        </script>
                    ";

                return 0;
            }
        }
    }
?>