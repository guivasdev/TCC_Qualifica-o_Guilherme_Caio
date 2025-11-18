<?php 
    class Cargo{
        private $id = 0;
        private $nome ="";
        private $sigla = "";

        public function getCargo($id, $nome){
            
            require_once 'MySql.php';
            $cargoPDO = new MySql();

            $sql = "SELECT * FROM cargo WHERE id = $id OR nome = $nome";

            if ($sql = $cargoPDO->query($sql)) {

                return $result->fetchAll(PDO::FETCH_ASSOC);
            } else {

                return 0;
            }
        }

        public function getALLCargos(){

            require_once 'MySql.php';
            $cargoPDO = new MySql();

            $sql = "SELECT * FROM cargo";

            if ($sql = $cargoPDO->query($sql)) {

                return $result->fetchAll(PDO::FETCH_ASSOC);
            } else {

                return 0;
            }
        }

        public function cadastrarCargo($nome, $sigla):int{

            require_once 'MySql.php';
            $cursoPDO = new MySql();
            
            $sql = "INSERT INTO cargo SET nome = $this->nome , sigla = $this->sigla";

            if ($sql = $cursoPDO->query($sql)) {
                
                // Cadastro realizado com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Cargo cadastrado com sucesso!\");
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
        public function editarCargo($id, $nome, $sigla):int{

            require_once 'MySql.php';
            $cargoPDO = new MySql();

            $sql = "UPDATE cargo SET nome = $nome , sigla = $sigla WHERE id = $id";

            if ($sql = $cargoPDO->query($sql)) {
                
                // Edição realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Cargo editado com sucesso!\");
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
        public function excluriarCargo($confirmar, $cargo):int{

            require_once 'MySql.php';
            $cargoPDO = new MySql();

            $sql = "DELETE FROM cargo WHERE id = $cargo->id"; #incluir desição para excluir, javascript alert ou um modal com botões?

            if ($sql = $cargoPDO->query($sql)) {
                
                // Exclusão realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Cargo excluído com sucesso!\");
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