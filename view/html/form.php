<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Cadastrar Campo</title>

<style>
body { background:#111; color:#fff; font-family:Arial; }
.container {
    width:400px; margin:50px auto; padding:20px;
    background:#222; border-radius:10px;
}
select, input, button {
    width:100%; padding:10px; margin-top:10px;
    background:#333; color:#fff; border:1px solid #555;
    border-radius:5px;
}
button { background:#0d6efd; cursor:pointer; }
button:hover { background:#0b5ed7; }
</style>
</head>
<body>

<div class="container">
    <h2>Cadastro</h2>

    <form action="?action=salvar" method="POST">

        <label>Selecione o campo:</label>
        <select name="campo" required>
            <option value="Organização">Organização</option>
            <option value="Núcleo Institucional">Núcleo Institucional</option>
            <option value="Curso">Curso</option>
            <option value="Integrantes">Integrantes</option>
        </select>

        <label>Valor:</label>
        <input type="text" name="valor" placeholder="Digite aqui..." required>

        <button type="submit">Salvar</button>
    </form>
</div>

</body>
</html>
