<?php
    class Documento{
        public $nome = "";
        public $predefinicao_id = null;
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
            return 0;
        }

        public function salvarVersao($documento): int{ #Versionamento
            return 0;
        }
        public function recuperarVersao($byteJson): int{ #Versionamento
            return 0;
        }

        public function getDocumento($id, $nome){ #banco de dados
            require_once 'model/MySql.php';
            $pdo = MySql::connect();

            $stmt = $pdo->prepare("SELECT * FROM documento WHERE id = :id OR nome = :nome");
            $stmt->execute([':id' => $id, ':nome' => $nome]);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $res ?: [];
        }

        public function getALLDocumentos(){ #banco de dados
            require_once 'model/MySql.php';
            $pdo = MySql::connect();

            $stmt = $pdo->query("SELECT * FROM documento");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function cadastrarDocumento($nome, $idOrganização, $idNucleo, $idCurso, $idLocalizacao, $idIntegrantes, $data, $hora, $prefacio, $introducao, $assunto, $encerramento, $predefinicaoId = null){ #banco de dados
            require_once 'model/MySql.php';
            $pdo = MySql::connect();

            // Normaliza nomes de parâmetro (alguns antigos usam caracteres especiais)
            $idOrganizacao = $idOrganização;
            $idNucleoInstitucional = $idNucleo;
            $fkCurso = $idCurso;
            $fkLocal = $idLocalizacao;
            $fkIntegrantes = $idIntegrantes;

            $sql = "INSERT INTO documento (titulo, organizacao_id, nucleo_id, curso_id, local_id, integrante_id, data, hora_inicio, prefacio, introducao, assunto, encerramento, conteudo, predefinicao_id) VALUES (:titulo, :organizacao_id, :nucleo_id, :curso_id, :local_id, :integrante_id, :data, :hora_inicio, :prefacio, :introducao, :assunto, :encerramento, :conteudo, :predefinicao_id)";

            $stmt = $pdo->prepare($sql);
            $ok = $stmt->execute([
                ':titulo' => $nome,
                ':organizacao_id' => $idOrganizacao,
                ':nucleo_id' => $idNucleoInstitucional,
                ':curso_id' => $fkCurso,
                ':local_id' => $fkLocal,
                ':integrante_id' => $fkIntegrantes,
                ':data' => $data,
                ':hora_inicio' => $hora,
                ':prefacio' => $prefacio,
                ':introducao' => $introducao,
                ':assunto' => $assunto,
                ':encerramento' => $encerramento,
                ':conteudo' => null,
                ':predefinicao_id' => $predefinicaoId
            ]);

            if ($ok) {
                echo "<script type=\"text/javascript\">alert('Documento cadastrado com sucesso!');</script>";
                return 1;
            } else {
                echo "<script type=\"text/javascript\">alert('Erro durante o cadastro.');</script>";
                return 0;
            }
        }

        public function EditarDocumento($id, $nome, $idOrganização, $idNucleo, $idCurso, $idLocalizacao, $idIntegrantes, $data, $hora, $prefacio, $introducao, $assunto, $encerramento, $predefinicaoId = null){ #banco de dados
            require_once 'model/MySql.php';
            $pdo = MySql::connect();

            // Normaliza nomes locais
            $idOrganizacao = $idOrganização;
            $idNucleoInstitucional = $idNucleo;
            $fkCurso = $idCurso;
            $fkLocal = $idLocalizacao;
            $fkIntegrantes = $idIntegrantes;

            $sql = "UPDATE documento SET titulo = :titulo, organizacao_id = :organizacao_id, nucleo_id = :nucleo_id, curso_id = :curso_id, local_id = :local_id, integrante_id = :integrante_id, data = :data, hora_inicio = :hora_inicio, prefacio = :prefacio, introducao = :introducao, assunto = :assunto, encerramento = :encerramento, conteudo = :conteudo, predefinicao_id = :predefinicao_id WHERE id = :id";

            $stmt = $pdo->prepare($sql);
            $ok = $stmt->execute([
                ':titulo' => $nome,
                ':organizacao_id' => $idOrganizacao,
                ':nucleo_id' => $idNucleoInstitucional,
                ':curso_id' => $fkCurso,
                ':local_id' => $fkLocal,
                ':integrante_id' => $fkIntegrantes,
                ':data' => $data,
                ':hora_inicio' => $hora,
                ':prefacio' => $prefacio,
                ':introducao' => $introducao,
                ':assunto' => $assunto,
                ':encerramento' => $encerramento,
                ':conteudo' => null,
                ':predefinicao_id' => $predefinicaoId,
                ':id' => $id
            ]);

            if ($ok) {
                echo "<script type=\"text/javascript\">alert('Documento editado com sucesso!');</script>";
                return 1;
            } else {
                echo "<script type=\"text/javascript\">alert('Erro durante a edição.');</script>";
                return 0;
            }
        }

        public function excluirDocumento($id): int{ #banco de dados
            require_once 'model/MySql.php';
            $pdo = MySql::connect();

            $stmt = $pdo->prepare("DELETE FROM documento WHERE id = :id");
            $ok = $stmt->execute([':id' => $id]);

            if ($ok) {
                echo "<script type=\"text/javascript\">alert('Documento excluído com sucesso!');</script>";
                return 1;
            } else {
                echo "<script type=\"text/javascript\">alert('Erro durante a exclusão.');</script>";
                return 0;
            }
        }
    }
?>