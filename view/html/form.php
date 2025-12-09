<?php
$base = '/TCC_Qualifica-o_Guilherme_Caio-master';

// Garante que as variáveis existam (evita tela branca)
$organizacoes = $organizacoes ?? [];
$nucleos = $nucleos ?? [];
$cursos = $cursos ?? [];
$cargos = $cargos ?? [];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo $base; ?>/externo/CriarAta.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Campo</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: white;
            font-family: "Segoe UI", Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .container {
            width: 100%;
            max-width: 420px;
            background:#fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
            animation: fadeIn 0.5s ease;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            color: #0d6efd;
            letter-spacing: 1px;
        }

        label {
            margin-top: 12px;
            font-weight: bold;
            display: block;
            font-size: 15px;
            color: #000000ff;
        }

        select,
        input,
        button {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            font-size: 15px;
            border-radius: 8px;
            border: 1px solid #444;
            background: #878484ff;
            color: #fff;
            transition: 0.2s ease-in-out;
        }
        input::placeholder{
            color: #fff;
        }

        button {
            margin-top: 20px;
            background: #0d6efd;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.25s;
        }

        button:hover {
            background: #0b5ed7;
            transform: translateY(-2px);
        }

        a.btn-voltar {
            display: block;
            margin-top: 15px;
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            background: #444;
            color: white;
            text-decoration: none;
            transition: 0.2s;
        }

        a.btn-voltar:hover {
            background: #666;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Cadastrar Dados</h2>

        <form action="?acao=salvarForm" method="POST" id="form-dinamico">
            <input type="hidden" name="tabela" id="tabela">

            <label>Escolha o tipo de cadastro:</label>
            <select id="tipo-cadastro">
                <option value="">Selecione...</option>
                <option value="organizacao">Organização</option>
                <option value="nucleo_institucional">Núcleo</option>
                <option value="curso">Curso</option>
                <option value="cargo">Cargo</option>
                <option value="integrante">Integrante</option>
            </select>

            <div id="campos-dinamicos"></div>

            <button type="submit" id="btn-salvar" style="display:none;">Salvar</button>

            <a href="<?php echo $base; ?>/index.php?acao=buscar" class="btn-voltar">Voltar</a>
        </form>
    </div>

    <script>
        const organizacoes = <?= json_encode($organizacoes ?? []) ?>;
        const nucleos = <?= json_encode($nucleos ?? []) ?>;
        const cursos = <?= json_encode($cursos ?? []) ?>;
        const cargos = <?= json_encode($cargos ?? []) ?>;

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

            if (tipo === 'organizacao') {
                camposDiv.innerHTML = `
                <label>Nome da Organização:</label>
                <input type="text" name="nome" required>
                <label>Sigla:</label>
                <input type="text" name="sigla" placeholder="Ex: DA" maxlength="32">
            `;
            }
            else if (tipo === 'nucleo_institucional') {
                let options = organizacoes.map(o => `<option value="${o.id}">${o.sigla ? o.sigla + ' | ' : ''}${o.nome}</option>`).join('');
                camposDiv.innerHTML = `
                <label>Selecione a Organização:</label>
                <select name="organizacao_id" required>
                    <option value="">Selecione...</option>
                    ${options}
                </select>

                <label>Nome do Núcleo:</label>
                <input type="text" name="nome" required>
                <label>Sigla:</label>
                <input type="text" name="sigla" placeholder="Ex: NT" maxlength="64">
            `;
            }
            else if (tipo === 'curso') {
                let options = nucleos.map(n => `<option value="${n.id}">${n.sigla ? n.sigla + ' | ' : ''}${n.nome}</option>`).join('');
                camposDiv.innerHTML = `
                <label>Selecione o Núcleo:</label>
                <select name="nucleo_id" required>
                    <option value="">Selecione...</option>
                    ${options}
                </select>

                <label>Nome do Curso:</label>
                <input type="text" name="nome" required>
            `;
            }
            else if (tipo === 'cargo') {
                camposDiv.innerHTML = `
                <label>Nome do Cargo:</label>
                <input type="text" name="nome" required>
                <label>Sigla:</label>
                <input type="text" name="sigla" placeholder="Ex: PRES" maxlength="32">
            `;
            }
            else if (tipo === 'integrante') {
                let cursoOptions = cursos.map(c => `<option value="${c.id}">${c.nome}</option>`).join('');
                let cargoOptions = cargos.map(c => `<option value="${c.id}">${c.sigla ? c.sigla + ' - ' : ''}${c.nome}</option>`).join('');

                camposDiv.innerHTML = `
                <label>Selecione o Curso:</label>
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
                <input type="text" name="nome" required>
            `;
            }
        });
    </script>

</body>

</html>