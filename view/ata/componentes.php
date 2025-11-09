<?php
function inputComPredef($label, $name, $opcoes)
{
  // Lista de nomes que devem usar textarea
  $textareaNames = ["infoIntro", "prefacio", "assunto", "encerramento"]; // adicione outros nomes se necessário

  echo '<div class="form-section">';
  echo "<label for='{$name}' class='form-label'>{$label}</label>";

  if (in_array($name, $textareaNames)) {
    // Usar textarea
    echo "<textarea id='{$name}' name='{$name}' class='form-control' rows='4'></textarea>";
  } else {
    // Usar input com datalist
    echo "<input list='{$name}_list' id='{$name}' name='{$name}' class='form-control'>";
    echo "<datalist id='{$name}_list'>";
    foreach ($opcoes as $opcao) {
      echo "<option value='{$opcao}'>";
    }
    echo "</datalist>";
  }

  echo '</div>';
}
?>