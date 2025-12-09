<?php
if (!function_exists('inputSelectEInput')) {

    function inputSelectEInput($label, $name, $opcoes)
    {
        $html = "<div class='form-section mb-3'>";
        $html .= "<label class='form-label'>{$label}</label>";

        // Wrapper para JS controlar visibilidade
        $html .= "<div class='d-flex gap-2'>";

        // SELECT
        $html .= "<select name='{$name}_id' id='select_{$name}' class='form-control' style='max-width:150px'>";
        $html .= "<option value=''>Selecionar</option>";

        // Para Integrante, mostramos a opção especial
        if ($name === "integrante") {
            $html .= "<option value='mostrar'>Selecionar vários</option>";
        }

        foreach ($opcoes as $op) {
            $html .= "<option value='{$op['id']}'>{$op['nome']}</option>";
        }

        $html .= "</select>";

        // Input novo (fica sempre visível para campos normais; para Integrante fica oculto até abrir)
        $html .= "<input type='text' class='form-control' 
            id='input_{$name}_novo'
            name='{$name}_novo' 
            placeholder='Novo {$label}'>";

        $html .= "</div>";

        // Área oculta dos checkboxes (somente para Integrante)
        if ($name === "integrante") {
            $html .= "<div id='bloco_integrantes' style='display:none; margin-top:10px; padding:10px; border:1px solid #555; border-radius:5px;'>";

            $html .= "<strong>Selecionar Integrantes:</strong><br>";

            $html .= "<div style='display:flex; flex-wrap:wrap; gap:10px; margin-top:5px;'>";

            foreach ($opcoes as $op) {
                $id = $op['id'];
                $nome = htmlspecialchars($op['nome']);
                
                $html .= "
                    <label style='display:flex; align-items:center; gap:5px;'>
                        <input type='checkbox' name='integrantes[]' value='{$id}'>
                        {$nome}
                    </label>
                ";
            }

            $html .= "</div>";

            $html .= "</div>";
        }

        $html .= "</div>";

        return $html;
    }
}

if (!function_exists('inputTextarea')) {

    function inputTextarea($label, $name)
    {
        $html = "<div class='form-section'>";
        $html .= "<label class='form-label' for='{$name}'>{$label}</label>";
        $html .= "<textarea class='form-control' id='{$name}' name='{$name}' rows='3'></textarea>";
        $html .= "</div>";

        return $html;

    }
}


?>