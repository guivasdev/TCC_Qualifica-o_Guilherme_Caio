<?php

class Local{
    private $id=0;
    private $nome="";

    public function getLocalizacao($id, $nome){

        require_once 'MySql.php';
        $PDOlocal = new MySql();

        $sql = "SELECT * FROM Localizacao WHERE id = '$id' OR nome = '$nome'";

        if($sql = $PDOlocal->query($sql)){
            
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{

            return 0;
        }
    }
    public function getALLLocalizacao(){

        require_once 'MySql.php';
        $PDOlocal = new MySql();

        $sql = "SELECT * FROM Localizacao";

        if($sql = $PDOlocal->query($sql)){
            
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{

            return 0;
        }
    }
    public function cadastrarLocal($nome): int{

        require_once 'MySql.php';
        $PDOlocal = new MySql();

        $sql = "INSERT INTO Localizacao SET nome = '$nome'";

        if($sql = $PDOlocal->query($sql)){
            
            // Cadastro realizado com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Localização cadastrado com sucesso!\");
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
    public function editarLocal($id, $nome): int{

        require_once 'MySql.php';
        $PDOlocal = new MySql();

        $sql = "UPDATE Localizacao SET nome = '$nome' WHERE id = '$id'";

        if($sql = $PDOlocal->query($sql)){
            
            // Edição realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Localização editada com sucesso!\");
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

    public function excluirLocal($confirmar, $id): int{

        require_once 'MySql.php';
        $PDOlocal = new MySql();

        $sql = "DELETE FROM Localizacao WHERE id = '$id'"; #incluir desição para excluir, javascript alert ou um modal com botões?

        if($sql = $PDOlocal->query($sql)){
            // Exclusão realizada com sucesso
                echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;>
                    <script type=\"text/javascript\">
                        alert(\"Localização excluída com sucesso!\");
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