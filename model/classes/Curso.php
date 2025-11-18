<?php 
    class Curso{
        private $id = 0;
        private $nome = "";

        public function getCurso($id, $nome){
            
            require_once 'model/MySql.php';
            $cursoPDO = new MySql;

            $sql = "SELECT * FROM Cursos WHERE id = '$id' OR nome = '$nome'";

            if ($sql = $cursoPDO->query($sql)) {

                return $sql->fetchALL(PDO::FETCH_ASSOC);
            }else{

                return 0;
            }
        }

        public function getALLCursos(){
            
            require_once 'model/MySql.php';
            $cursoPDO = new MySql;

            $sql = "SELECT * FROM Cursos";

            if ($sql = $cursoPDO->query($sql)) {

                return $sql->fetchALL(PDO::FETCH_ASSOC);
            }else{

                return 0;
            }
        }

        public function cadastrarCurso($nome): int {

            require_once 'model/MySql.php';
            $cursoPDO = new MySql;

            $sql = "INSERT INTO Curso SET nome = '$nome'";

            if ($sql = $cursoPDO->query($sql)) {

                // Cadastro realizado com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Curso cadastrado com sucesso!\");
                    </script>
                    ";

                return 1;
            } else {
            
                // Caso ocorra falha
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                        <script type=\"text/javascript\">
                            alert(\"Erro durante o cadastro.\");
                        </script>
                    ";

                return 0;
            }
        }
        public function editarCurso($id, $nome):int{

            require_once 'model/MySql.php';
            $cursoPDO = new MySql;

            $sql = "UPDATE Cursos SET nome = '$nome' WHERE id = '$id'";

            if ($sql = $cursoPDO->query($sql)) {

                // Edição realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Curso editado com sucesso!\");
                    </script>
                    ";

                return 1;
            } else {
            
                // Caso ocorra falha
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                        <script type=\"text/javascript\">
                            alert(\"Erro durante a edição.\");
                        </script>
                    ";

                return 0;
            }
        }
        public function excluirCurso($confirmar, $curso):int{

            require_once 'model/MySql.php';
            $cursoPDO = new MySql;

            $sql = "DELETE FROM Cursos WHERE id = '$curso'"; #incluir desição para excluir, javascript alert ou um modal com botões?

            if ($sql = $cursoPDO->query($sql)) {

                // Exclusão realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Curso excluído com sucesso!\");
                    </script>
                    ";

                return 1;
            } else {
            
                // Caso ocorra falha
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                        <script type=\"text/javascript\">
                            alert(\"Erro durante a exclusão.\");
                        </script>
                    ";

                return 0;
            }
        }
    }
?>