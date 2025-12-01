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

            $sql = "INSERT INTO documento (titulo, organizacao_id, nucleo_id, curso_id, local_id, data, hora_inicio, prefacio, introducao, assunto, encerramento, conteudo, predefinicao_id) VALUES (:titulo, :organizacao_id, :nucleo_id, :curso_id, :local_id, :data, :hora_inicio, :prefacio, :introducao, :assunto, :encerramento, :conteudo, :predefinicao_id)";

            $stmt = $pdo->prepare($sql);
            $ok = $stmt->execute([
                ':titulo' => $nome,
                ':organizacao_id' => $idOrganizacao,
                ':nucleo_id' => $idNucleoInstitucional,
                ':curso_id' => $fkCurso,
                ':local_id' => $fkLocal,
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
                $newId = (int)$pdo->lastInsertId();

                // vincula integrantes (se informado) na join table documento_integrante
                if (!empty($fkIntegrantes)) {
                    if (is_array($fkIntegrantes)) {
                        foreach ($fkIntegrantes as $i) {
                            $ins = $pdo->prepare('INSERT IGNORE INTO documento_integrante (documento_id, integrante_id) VALUES (:doc, :integ)');
                            $ins->execute([':doc' => $newId, ':integ' => (int)$i]);
                        }
                    } else {
                        $ins = $pdo->prepare('INSERT IGNORE INTO documento_integrante (documento_id, integrante_id) VALUES (:doc, :integ)');
                        $ins->execute([':doc' => $newId, ':integ' => (int)$fkIntegrantes]);
                    }
                }

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

            $sql = "UPDATE documento SET titulo = :titulo, organizacao_id = :organizacao_id, nucleo_id = :nucleo_id, curso_id = :curso_id, local_id = :local_id, data = :data, hora_inicio = :hora_inicio, prefacio = :prefacio, introducao = :introducao, assunto = :assunto, encerramento = :encerramento, conteudo = :conteudo, predefinicao_id = :predefinicao_id WHERE id = :id";

            $stmt = $pdo->prepare($sql);
            $ok = $stmt->execute([
                ':titulo' => $nome,
                ':organizacao_id' => $idOrganizacao,
                ':nucleo_id' => $idNucleoInstitucional,
                ':curso_id' => $fkCurso,
                ':local_id' => $fkLocal,
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
                // atualiza mapping de integrantes: remover antigos e inserir os novos (se informado)
                if (!empty($fkIntegrantes)) {
                    // remove mapeamentos antigos
                    $pdo->prepare('DELETE FROM documento_integrante WHERE documento_id = :doc')->execute([':doc' => $id]);
                    // insere novos
                    if (is_array($fkIntegrantes)) {
                        foreach ($fkIntegrantes as $i) {
                            $ins = $pdo->prepare('INSERT IGNORE INTO documento_integrante (documento_id, integrante_id) VALUES (:doc, :integ)');
                            $ins->execute([':doc' => $id, ':integ' => (int)$i]);
                        }
                    } else {
                        $ins = $pdo->prepare('INSERT IGNORE INTO documento_integrante (documento_id, integrante_id) VALUES (:doc, :integ)');
                        $ins->execute([':doc' => $id, ':integ' => (int)$fkIntegrantes]);
                    }
                }

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

        // ---------------- helpers para documento_integrante (N:N)
        public function adicionarIntegrante($documentoId, $integranteId){
            require_once 'model/MySql.php';
            $pdo = MySql::connect();
            $stmt = $pdo->prepare('INSERT IGNORE INTO documento_integrante (documento_id, integrante_id) VALUES (:doc, :integ)');
            return $stmt->execute([':doc' => $documentoId, ':integ' => $integranteId]);
        }

        public function removerIntegrante($documentoId, $integranteId){
            require_once 'model/MySql.php';
            $pdo = MySql::connect();
            $stmt = $pdo->prepare('DELETE FROM documento_integrante WHERE documento_id = :doc AND integrante_id = :integ');
            return $stmt->execute([':doc' => $documentoId, ':integ' => $integranteId]);
        }

        public function listarIntegrantes($documentoId){
            require_once 'model/MySql.php';
            $pdo = MySql::connect();
            $stmt = $pdo->prepare('SELECT i.* FROM integrante i JOIN documento_integrante di ON i.id = di.integrante_id WHERE di.documento_id = :doc');
            $stmt->execute([':doc' => $documentoId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>