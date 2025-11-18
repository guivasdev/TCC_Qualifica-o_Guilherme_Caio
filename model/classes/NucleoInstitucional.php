<?php 
    class NucleoInstitucional{
        private $id = 0;
        private $nome = "";
        private $integrantes = [];
        private $sigla ="";
        public function getNucleoInstitucional($id, $nome){
            
            require_once 'MySql.php';
            $PDONucleo = new MySql();
            
            $sql = "SELECT * FROM Nucleos_Institucionais WHERE id = '$id' OR nome = '$nome'";

            if ($sql = $PDONucleo->query($sql)) {
                
                return $sql->fetch(PDO::FETCH_ASSOC);
            }else{

                return 0;
            }

        }
        public function gelALLNucleoInstitucional(){

            require_once 'MySql.php';
            $PDONucleo = new MySql();

            $sql = "SELECT * FROM Nucleos_Institucionais";

            if ($sql = $PDONucleo->query($sql)) {
                
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }else{

                return 0;
            }
        
        }
        public function cadastrarNucleo($nome){

            require_once 'MySql.php';
            $PDONucleo = new MySql();

            $sql = "INSERT INTO Nucleos_Institucionais SET nome = '$nome'";

            if ($sql = $PDONucleo->query($sql)) {
                
                // Cadastro realizado com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Núcleos Institucionais cadastrado com sucesso!\");
                    </script>
                ";

                return 1;
            }else{

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
        public function adicionarIntegrante($id, $idInteg){
            
            require_once 'MySql.php';
            $PDONucleo = new MySql();

            $sql = "INSERT INTO Nucleos_Institucionais SET fk_Integrantes_Id = '$idInteg' WHERE id = '$id'";

             if ($sql = $PDONucleo->query($sql)) {
                
                // Cadastro realizado com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Integrante adicionado com sucesso!\");
                    </script>
                ";

                return 1;
            }else{

                // Caso ocorra falha
                    echo "
                        <META HTTP-EQUIV=REFRESH CONTENT='0;>
                            <script type=\"text/javascript\">
                                alert(\"Erro durante a adiçao.\");
                            </script>
                    ";
             return 0;
            }
        }
        public function removerIntegrante($id, $idInteg){

            require_once 'MySql.php';
            $PDONucleo = new MySql();

            $sql = "UPDATE Nucleos_Institucionais SET fk_Integrantes_Id = NULL WHERE id = '$id' AND fk_Integrantes_Id = '$idInteg'";

             if ($sql = $PDONucleo->query($sql)) {
                
                // Remoção realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Integrante removido com sucesso!\");
                    </script>
                ";

                return 1;
            }else{
                // Caso ocorra falha
                    echo "
                        <META HTTP-EQUIV=REFRESH CONTENT='0;>
                            <script type=\"text/javascript\">
                                alert(\"Erro durante a remoção.\");
                            </script>
                    ";
             return 0;
            }
        }
        public function editarNucleo($id){

            require_once 'MySql.php';
            $PDONucleo = new MySql();

            $sql = "UPDATE Nucleos_Institucionais SET nome = '$this->nome' WHERE id = '$id'";

            if ($sql = $PDONucleo->query($sql)) {
                
                // Edição realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Núcleo Institucional editado com sucesso!\");
                    </script>
                ";

                return 1;
            }else{
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
        public function excluirNucleo($confirmar, $id){
            
            require_once 'MySql.php';
            $PDONucleo = new MySql();

            $sql = "DELETE FROM Nucleos_Institucionais WHERE id = '$id'";#incluir desição para excluir, javascript alert ou um modal com botões?

            #if ($confirmar == true) {
                if ($sql = $PDONucleo->query($sql)) {
                    
                    // Exclusão realizada com sucesso
                    echo "
                        <META HTTP-EQUIV=REFRESH CONTENT='0;>
                        <script type=\"text/javascript\">
                            alert(\"Núcleo Institucional excluído com sucesso!\");
                        </script>
                    ";

                    return 1;
                }else{
                    // Caso ocorra falha
                        echo "
                            <META HTTP-EQUIV=REFRESH CONTENT='0;>
                                <script type=\"text/javascript\">
                                    alert(\"Erro durante a exclusão.\");
                                </script>
                        ";
                 return 0;
                }
            #}
        }
        
    }
?>