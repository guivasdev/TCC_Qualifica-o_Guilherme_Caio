<?php
if (!function_exists('inputSelectEInput')) {

    function inputSelectEInput($label, $name, $opcoes)
    {
        $html = "<div class='form-section'>";
        $html .= "<label class='form-label'>{$label}</label>";

        // SELECT vindo do banco
        $html .= "<div class='d-flex gap-2'>";

        $html .= "<select name='{$name}_id' class='form-control' style='max-width:150px'>";
        $html .= "<option value=''>Selecionar</option>";

        foreach ($opcoes as $op) {
            $html .= "<option value='{$op['id']}'>{$op['nome']}</option>";
        }

        $html .= "<option value='{$op['id']}'>{$op['nome']}</option>";

        $html .= "</select>";

        // INPUT para novo valor
        $html .= "<input type='text' class='form-control' name='{$name}_novo' placeholder='Novo {$label}'>";

        $html .= "</div></div>";

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