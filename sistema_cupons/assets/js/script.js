document.addEventListener("DOMContentLoaded", function () {
    const formularios = document.querySelectorAll(".formulario-excluir");

    formularios.forEach(function (formulario) {
        formulario.addEventListener("submit", function (evento) {
            const confirmou = confirm(
                "Tem certeza de que deseja excluir este cupom?"
            );

            if (!confirmou) {
                evento.preventDefault();
            }
        });
    });
});
