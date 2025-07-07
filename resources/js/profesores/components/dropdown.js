$("button[data-id]").on("click", function (e) {
    e.stopPropagation();
    const dataId = $(this).data("id");
    const $dropdown = $('[data-id="' + dataId + '"]').not("button");

    // Cerrar otros dropdowns
    $("[data-id]").not("button").not($dropdown).addClass("hidden");

    // Toggle el dropdown actual
    $dropdown.toggleClass("hidden");
});

// Cerrar dropdown al hacer clic fuera
$(document).on("click", function () {
    $("[data-id]").not("button").addClass("hidden");
});

// Evitar que el clic dentro del dropdown lo cierre
$("[data-id]")
    .not("button")
    .on("click", function (e) {
        e.stopPropagation();
    });
