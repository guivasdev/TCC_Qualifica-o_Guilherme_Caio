<?php 
    class Integrante{
        private $id = 0;
        private $nome = "";
        private $cargo = "";

        public function getIntegrantes($id, $nome){

            require_once 'MySql.php';
            $PDOintegrante = new MySql();

            $sql = "SELECT * FROM Integrantes WHERE id = '$id' OR nome = '$nome'";

            if ($sql = $PDOintegrante->query($sql)) {

                return $sql->fetchAll(PDO::FETCH_ASSOC);
            } else {

                return 0;
            }
        }
        public function getALLIntegrantes(){

            require_once 'MySql.php';
            $PDOintegrante = new MySql();

            $sql = "SELECT * FROM Integrantes";

            if ($sql = $PDOintegrante->query($sql)) {

                return $sql->fetchAll(PDO::FETCH_ASSOC);
            } else {

                return 0;
            }
        }
        public function cadastrarIntegrantes($nome, $cargo): int{

            require_once 'MySql.php';
            $PDOintegrante = new MySql();

            $sql = "INSERT INTO Integrantes SET nome = $nome', cargo = '$cargo'";

            if ($sql = $PDOintegrante->query($sql)) {

                // Cadastro realizado com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Integrante cadastrado com sucesso!\");
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
        public function atribuirCargo($id, $id_cargo): int{

            require_once 'MySql.php';
            $PDOintegrante = new MySql();

            $sql = "UPDATE Integrantes SET cargo = '$id_cargo' WHERE id = '$id'"; 

            if($sql = $PDOintegrante->query($sql)){

                return 1;
            } else {

                return 0;
            }
        }
        public function editarIntegrantes($id, $nome, $cargo): int{

            require_once 'MySql.php';
            $PDOintegrante = new MySql();

            $sql = "UPDATE Integrantes SET nome = '$nome', cargo = '$cargo' WHERE id = '$id'"; 

            if($sql = $PDOintegrante->query($sql)){

                // Edição realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Integrante editado com sucesso!\");
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
        public function excluirIntegrante($confirmar, $id): int{

            require_once 'MySql.php';
            $PDOintegrante = new MySql();

            $sql = "DELETE FROM Integrantes WHERE id = '$id'"; #incluir desição para excluir, javascript alert ou um modal com botões?

            if($sql = $PDOintegrante->query($sql)){

                // Exclusão realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Integrante excluído com sucesso!\");
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