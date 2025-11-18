<?php 
    class Organizacao{
        private $id = 0;
        private $nome ="";
        private $nucleoInstitucional = [];
        private $curso =[];
        private $integrantes = [];
  
        public function getOrganizacao($id, $nome){

            require_once 'MySQL.php';
            $PDOOrganizacao = new MySQL();

            $sql = "SELECT * FROM organizacao WHERE id = '$id' OR nome = '$nome'";
            
            if ($sql = $PDOOrganizacao->query($sql)) {
                
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }else{

                return 0;
            }
        }
        public function getALLOrganizacoes(){

            require_once 'MySQL.php';
            $PDOOrganizacao = new MySQL();

            $sql = "SELECT * FROM organizacao";

            if ($sql = $PDOOrganizacao->query($sql)) {
                
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }else{

                return 0;
            }
        }
        public function cadastrarOrganizacao($nome){

            require_once 'MySQL.php';
            $PDOOrganizacao = new MySQL();

            $sql = "INSERT INTO Organizacoes SET nome = '$nome'";

            if ($sql = $PDOOrganizacao->query($sql)) {
                
                // Cadastro realizado com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Organização cadastrado com sucesso!\");
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
        public function adicionarNucleo($id, $idNucleo){

            require_once 'MySQL.php';
            $PDOOrganizacao = new MySQL();

            $sql = "INSERT INTO Organizacoes SET fk_Nucleos_Institucionais_Id  = '$idNucleo' WHERE id = '$id'";

            if ($sql = $PDOOrganizacao->query($sql)) {
                
               // Cadastro realizado com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Núcleo Institucional adcionado com sucesso!\");
                    </script>
                ";

                return 1;
            }else{

                // Caso ocorra falha
                    echo "
                        <META HTTP-EQUIV=REFRESH CONTENT='0;>
                            <script type=\"text/javascript\">
                                alert(\"Erro durante a adição.\");
                            </script>
                    ";
             return 0;
            }
        }
        public function removerNucleo($id, $idNucleo){
            
            require_once 'MySQL.php';
            $PDOOrganizacao = new MySQL();

            $sql = "UPDATE Organizacoes SET fk_Nucleos_Institucionais_Id = NULL WHERE fk_Nucleos_Institucionais_Id  = '$idNucleo' AND id = '$id'";

            if ($sql = $PDOOrganizacao->query($sql)) {
                
               // Remoção realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Núcleo Institucional removido com sucesso!\");
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
        public function adicionarCurso($id, $idCurso){

            require_once 'MySQL.php';
            $PDOOrganizacao = new MySQL();

            $sql = "INSERT INTO Organizacoes SET fk_Curso_Id  = '$idCurso' WHERE id = '$id'";

            if ($sql = $PDOOrganizacao->query($sql)) {
                
               // Cadastro realizado com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Curso adcionado com sucesso!\");
                    </script>
                ";

                return 1;
            }else{
                // Caso ocorra falha
                    echo "
                        <META HTTP-EQUIV=REFRESH CONTENT='0;>
                            <script type=\"text/javascript\">
                                alert(\"Erro durante a adição.\");
                            </script>
                    ";
             return 0;
            }
        }
        public function removerCurso($id, $idCurso){

            require_once 'MySQL.php';
            $PDOOrganizacao = new MySQL();

            $sql = "UPDATE Organizacoes SET fk_Curso_Id = NULL WHERE fk_Curso_Id  = '$idCurso' AND id = '$id'";

            if ($sql = $PDOOrganizacao->query($sql)) {
                
               // Remoção realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Curso removido com sucesso!\");
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
        public function adicionarIntegrantes($id, $idIntegrantes){

            require_once 'MySQL.php';
            $PDOOrganizacao = new MySQL();

            $sql = "INSERT INTO Organizacoes SET fk_Integrantes_Id  = '$idIntegrantes' WHERE id = '$id'";

            if ($sql = $PDOOrganizacao->query($sql)) {
                
               // Cadastro realizado com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Integrante adcionado com sucesso!\");
                    </script>
                ";

                return 1;
            }else{
                // Caso ocorra falha
                    echo "
                        <META HTTP-EQUIV=REFRESH CONTENT='0;>
                            <script type=\"text/javascript\">
                                alert(\"Erro durante a adição.\");
                            </script>
                    ";
             return 0;
            }
        }
        public function removerIntegrante($id, $idIntegrante){
            
            require_once 'MySQL.php';
            $PDOOrganizacao = new MySQL();

            $sql = "UPDATE Organizacoes SET fk_Integrantes_Id = NULL WHERE fk_Integrantes_Id  = '$idIntegrante' AND id = '$id'";

            if ($sql = $PDOOrganizacao->query($sql)) {
                
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
        public function adicionarLocalizacao($id, $idLocalizacao){

            require_once 'MySQL.php';
            $PDOOrganizacao = new MySQL();

            $sql = "INSERT INTO Organizacoes SET fk_Local_Id = '$idLocalizacao' WHERE id = '$id'";

            if ($sql = $PDOOrganizacao->query($sql)) {
                
               // Cadastro realizado com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Localização adcionada com sucesso!\");
                    </script>
                ";

                return 1;
            }else{
                // Caso ocorra falha
                    echo "
                        <META HTTP-EQUIV=REFRESH CONTENT='0;>
                            <script type=\"text/javascript\">
                                alert(\"Erro durante a adição.\");
                            </script>
                    ";
             return 0;
            }
        }
        public function removerLocalizacao($id, $idLocalizacao){

            require_once 'MySQL.php';
            $PDOOrganizacao = new MySQL();

            $sql = "UPDATE Organizacoes SET fk_Local_Id = NULL WHERE fk_Local_Id  = '$idLocalizacao' AND id = '$id'";

            if ($sql = $PDOOrganizacao->query($sql)) {
                
               // Remoção realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Localização removida com sucesso!\");
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
        public function editarOrganizacao($id, $nome){

            require_once 'MySQL.php';
            $PDOOrganizacao = new MySQL();

            $sql = "UPDATE Organizacoes SET nome = '$nome' WHERE id = '$id'";

            if ($sql = $PDOOrganizacao->query($sql)) {
                
               // Edição realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Organização editada com sucesso!\");
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
        public function excluirOrganizacao($confirmar, $id){

            require_once 'MySQL.php';
            $PDOOrganizacao = new MySQL();

            $sql = "DELETE FROM Organizacoes WHERE id = '$id'";#incluir desição para excluir, javascript alert ou um modal com botões?

            if ($sql = $PDOOrganizacao->query($sql)) {
                
               // Exclusão realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Organização excluída com sucesso!\");
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
        }
        
    }
?>