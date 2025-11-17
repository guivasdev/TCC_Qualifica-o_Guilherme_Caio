<?php
$base = '/TCC_Qualifica-o_Guilherme_Caio';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo $base; ?>/externo/CriarAta.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Campo</title>

    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            color: #0d6efd;
            letter-spacing: 1px;
        }

        label {
            margin-top: 12px;
            display: block;
            font-size: 15px;
            color: #ddd;
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
            background: #1e1e1e;
            color: #fff;
            transition: 0.2s ease-in-out;
        }

        select:focus,
        input:focus {
            border-color: #0d6efd;
            outline: none;
            background: #262626;
        }

        button {
            margin-top: 20px;
            background: #0d6efd;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.25s;
            letter-spacing: 0.5px;
        }

        button:hover {
            background: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
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

        /* Responsividade */
        @media (max-width: 480px) {
            .container {
                padding: 22px;
            }

            h2 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
    <h2>Cadastrar Dados</h2>

    <form action="?acao=salvar" method="POST">

        <!-- Organização -->
        <label>Organização:</label>
        <input type="text" name="organizacao_nome" placeholder="Nome da Organização">

        <!-- Núcleo -->
        <label>Núcleo:</label>
        <select name="nucleo_organizacao_id">
            <option value="">Selecione a organização</option>
            <?php foreach ($organizacoes as $org): ?>
                <option value="<?= $org['id'] ?>"><?= htmlspecialchars($org['nome']) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="nucleo_nome" placeholder="Nome do Núcleo">

        <!-- Curso -->
        <label>Curso:</label>
        <select name="curso_nucleo_id">
            <option value="">Selecione o núcleo</option>
            <?php foreach ($nucleos as $nuc): ?>
                <option value="<?= $nuc['id'] ?>"><?= htmlspecialchars($nuc['nome']) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="curso_nome" placeholder="Nome do Curso">

        <!-- Cargo -->
        <label>Cargo:</label>
        <input type="text" name="cargo_nome" placeholder="Nome do Cargo">

        <!-- Integrante -->
        <label>Integrante:</label>
        <select name="integrante_curso_id">
            <option value="">Selecione o curso</option>
            <?php foreach ($cursos as $cur): ?>
                <option value="<?= $cur['id'] ?>"><?= htmlspecialchars($cur['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <select name="integrante_cargo_id">
            <option value="">Selecione o cargo</option>
            <?php foreach ($cargos as $car): ?>
                <option value="<?= $car['id'] ?>"><?= htmlspecialchars($car['nome']) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="integrante_nome" placeholder="Nome do Integrante">

        <button type="submit">Salvar Tudo</button>
    </form>
</div>



</body>

</html>