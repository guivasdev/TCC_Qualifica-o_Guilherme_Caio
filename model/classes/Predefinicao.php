<?php 
    class Predefiniao{
        public $nucleoInstitucional = "";
        public $curso = "";
        public $organizacao = "";
        public $data = "";
        public $local = "";
        public $hora = "";
        public $integrantes = "";
        public $introducao = "";
        public $assunto = "";
        public $encerramento = "";
        public$prefacio = "";

        public function getPredefinicao($id, $nome){ #banco de dados

            require_once 'model/MySql.php';
            $PredefinicaoPDO = new MySql;

            $sql = "SELECT * FROM Predefinicoes WHERE id = '$id' OR nome = '$nome'";

            if ($sql = $PredefinicaoPDO->query($sql)) {
                
                return $sql->fetchAll(PDO::FETCH_ASSOC);

            }else {
            
                return 0;
            }
        }

        public function getALLPredefinicaos(){ #banco de dados

            require_once 'model/MySql.php';
            $PredefinicaoPDO = new MySql;

            $sql = "SELECT * FROM Predefinicoes";

            if ($sql = $PredefinicaoPDO->query($sql)) {
                
                return $sql->fetchAll(PDO::FETCH_ASSOC);

            }else {
            
                return 0;
            }
        }

        public function cadastrarPredefinicao($nome, $idOrganização, $idNucleo, $idCurso, $idLocalizacao, $idIntegrantes, $data, $hora, $prefacio, $introducao, $assunto, $encerramento){ #banco de dados
            
            require_once 'model/MySql.php';
            $PredefinicaoPDO = new MySql;

            $sql = "INSERT INTO Predefinicoes SET Nome = '$nome', fk_Organizacoes_Id = '$idOrganização', fk_Nucleos_Institucionais_Id = '$idNucleo', fk_Curso_Id = '$idCurso' fk_Localizacao_Id = '$idLocalizacao', fk_Integrantes_Id = '$idIntegrantes', Dia = '$data', Hora = '$hora', Prefacio = '$prefacio', Introducao' = $introducao', Assunto = '$assunto', Encerramento = '$encerramento' ";

            if ($sql = $PredefinicaoPDO->query($sql)) {
                
                // Cadastro realizado com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0; URL=vendas.php'>
                    <script type=\"text/javascript\">
                        alert(\"Predefinição cadastrada com sucesso!\");
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

        public function EditarPredefinicao($id, $nome, $idOrganização, $idNucleo, $idCurso, $idLocalizacao, $idIntegrantes, $data, $hora, $prefacio, $introducao, $assunto, $encerramento){ #banco de dados

            require_once 'model/MySql.php';
            $PredefinicaoPDO = new MySql;

            $sql = "UPDATE Predefinicoes SET Nome = '$nome', fk_Organizacoes_Id = '$organizacao', fk_Nucleos_Institucionais_Id = '$nucleoInstitucional', fk_Curso_Id = '$curso' fk_Localizacao_Id = '$local', fk_Integrantes_Id = '$integrantes', Dia = '$data', Hora = '$horas', Prefacio = '$prefacio', Introducao' = $introducao', Assunto = '$assunto', Encerramento = '$encerramento' WHERE id = '$id' ";

            if ($sql = $PredefinicaoPDO->query($sql)) {
                
                // Edição realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Predefinição editado com sucesso!\");
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

        public function excluirPredefinicao($id): int{ #banco de dados

            require_once 'model/MySql.php';
            $PredefinicaoPDO = new MySql;

            $sql = "DELETE FROM Predefinicoes WHERE id = '$id'"; #incluir desição para excluir, javascript alert ou um modal com botões?

            if ($sql = $PredefinicaoPDO->query($sql)) {
                
                // Exclusão realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Predefinição excluído com sucesso!\");
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