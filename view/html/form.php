<?php
$base = '/TCC_Qualifica-o_Guilherme_Caio-master';

// Garante que as variáveis de dados existam para o JavaScript
$organizacoes = isset($organizacoes) ? $organizacoes : [];
$nucleos = isset($nucleos) ? $nucleos : [];
$cursos = isset($cursos) ? $cursos : [];
$cargos = isset($cargos) ? $cargos : [];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?= $base; ?>/externo/CriarAta.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Campo</title>
    <style>
        /* Reset básico */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: linear-gradient(135deg, #0d0d0d, #1a1a1a);
            font-family: "Segoe UI", Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            color: #fff;
        }

        .container {
            width: 100%;
            max-width: 420px;
            background: rgba(34, 34, 34, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
            animation: fadeIn 0.5s ease;
        }

        h2 { text-align: center; margin-bottom: 20px; font-weight: 600; color: #0d6efd; letter-spacing: 1px; }
        label { margin-top: 12px; display: block; font-size: 15px; color: #ddd; }
        select, input, button {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            font-size: 15px;
            border-radius: 8px;
            border: 1px solid #444;
            background: #1e1e1e;
            color: #fff;
            transition: 0.2s ease-in-out;
        }
        select:focus, input:focus { border-color: #0d6efd; outline: none; background: #262626; }
        button {
            margin-top: 20px;
            background: #0d6efd;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.25s;
            letter-spacing: 0.5px;
        }
        button:hover { background: #0b5ed7; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4); }
        .form-group { margin-bottom: 20px; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 480px) { .container { padding: 22px; } h2 { font-size: 22px; } }
    </style>
</head>

<body>
    <div class="container">
        <h2>Cadastrar Dados</h2>
        <form action="?acao=salvar" method="POST" id="form-dinamico">
            <input type="hidden" name="tabela" id="tabela">
            <div class="form-group">
                <label>Escolha o tipo de cadastro:</label>
                <select id="tipo-cadastro">
                    <option value="">Selecione...</option>
                    <option value="organizacao">Organização</option>
                    <option value="nucleo">Núcleo</option>
                    <option value="curso">Curso</option>
                    <option value="cargo">Cargo</option>
                    <option value="integrante">Integrante</option>
                </select>
            </div>
            <!-- Campos Dinâmicos -->
            <div id="campos-dinamicos"></div>

            <button type="submit" id="btn-salvar" style="display:none;">Salvar</button>
            <a href="<?= $base; ?>/index.php?acao=buscar" class="btn btn-secondary px-4 py-4 fs-5">
                Voltar
            </a>
        </form>
    </div>

    <script>
        // Dados do banco
        const organizacoes = <?= json_encode($organizacoes) ?>;
        const nucleos = <?= json_encode($nucleos) ?>;
        const cursos = <?= json_encode($cursos) ?>;
        const cargos = <?= json_encode($cargos) ?>;

        const tipoSelect = document.getElementById('tipo-cadastro');
        const camposDiv = document.getElementById('campos-dinamicos');
        const tabelaInput = document.getElementById('tabela');
        const btnSalvar = document.getElementById('btn-salvar');

        tipoSelect.addEventListener('change', function () {
            camposDiv.innerHTML = '';
            btnSalvar.style.display = 'none';
            tabelaInput.value = '';

            const tipo = this.value;
            if (!tipo) return;

            tabelaInput.value = tipo;
            btnSalvar.style.display = 'block';

            switch (tipo) {
                case 'organizacao':
                    camposDiv.innerHTML = `<label>Nome da Organização:</label>
                                           <input type="text" name="nome" placeholder="Digite o nome da organização" required>`;
                    break;

                case 'nucleo':
                    let orgOptions = organizacoes.map(o => `<option value="${o.id}">${o.nome}</option>`).join('');
                    camposDiv.innerHTML = `<label>Selecione a Organização:</label>
                                           <select name="organizacao_id" required>
                                               <option value="">Selecione...</option>
                                               ${orgOptions}
                                           </select>
                                           <label>Nome do Núcleo:</label>
                                           <input type="text" name="nome" placeholder="Digite o nome do núcleo" required>`;
                    break;

                case 'curso':
                    let nucOptions = nucleos.map(n => `<option value="${n.id}">${n.nome}</option>`).join('');
                    camposDiv.innerHTML = `<label>Selecione o Núcleo:</label>
                                           <select name="nucleo_id" required>
                                               <option value="">Selecione...</option>
                                               ${nucOptions}
                                           </select>
                                           <label>Nome do Curso:</label>
                                           <input type="text" name="nome" placeholder="Digite o nome do curso" required>`;
                    break;

                case 'cargo':
                    camposDiv.innerHTML = `<label>Nome do Cargo:</label>
                                           <input type="text" name="nome" placeholder="Digite o nome do cargo" required>`;
                    break;

                case 'integrante':
                    let cursoOptions = cursos.map(c => `<option value="${c.id}">${c.nome}</option>`).join('');
                    let cargoOptions = cargos.map(c => `<option value="${c.id}">${c.nome}</option>`).join('');
                    camposDiv.innerHTML = `<label>Selecione o Curso:</label>
                                           <select name="curso_id" required>
                                               <option value="">Selecione...</option>
                                               ${cursoOptions}
                                           </select>
                                           <label>Selecione o Cargo:</label>
                                           <select name="cargo_id" required>
                                               <option value="">Selecione...</option>
                                               ${cargoOptions}
                                           </select>
                                           <label>Nome do Integrante:</label>
                                           <input type="text" name="nome" placeholder="Digite o nome do integrante" required>`;
                    break;
            }
        });
    </script>
</body>
</html>
