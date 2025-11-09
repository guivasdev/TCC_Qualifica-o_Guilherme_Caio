<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Normalização do campo Nome
(function(){
  const input = document.getElementById("nome");
  if (!input) return;

  function normalizeText(text) {
    return text
      .replace(/(\d+)[\s\n\r\u00A0\u200B]*a(?![\w>])/gi, "$1ª")
      .replace(/(\d+)[\s\n\r\u00A0\u200B]*o(?![\w>])/gi, "$1º");
  }

  input.addEventListener("input", () => {
    const start = input.selectionStart;
    const end = input.selectionEnd;
    const newValue = normalizeText(input.value);
    if (newValue !== input.value) {
      input.value = newValue;
      input.setSelectionRange(start, end);
    }
  });

  input.addEventListener("paste", (e) => {
    e.preventDefault();
    const clipboard = e.clipboardData || window.clipboardData;
    let text = clipboard.getData("text/plain");
    document.execCommand("insertText", false, normalizeText(text));
  });
})();

// Predefinidos clicáveis
$(function() {
  $(".dropdown-item.predef").on("click", function() {
    const target = $(this).data("target");
    const value = $(this).text();
    $("#" + target).val(value);
  });

  $("#formAta").on("submit", function() {
    alert("✅ ATA criada com sucesso!");
  });
});
</script>
