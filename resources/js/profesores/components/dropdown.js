$("button[data-dropdown-button-id]").on("click", function (e) {
    e.stopPropagation();
    const dataId = $(this).data("dropdown-button-id");
    const $dropdownButton = $(this);
    const $dropdown = $('[data-dropdown-id="' + dataId + '"]').not("button");
    const $options = $dropdown.find("button");

    $options.on("click", function () {
        console.log($dropdownButton.text());
        const texto = $(this).text();
        $dropdownButton.find("span").text(texto);
        $dropdown.addClass("hidden");
    });
    // Cerrar otros dropdowns
    $("[data-dropdown-id]").not("button").not($dropdown).addClass("hidden");

    // Toggle el dropdown actual
    $dropdown.toggleClass("hidden");
});

// Cerrar dropdown al hacer clic fuera
$(document).on("click", function () {
    $("[data-dropdown-id]").not("button").addClass("hidden");
});

// Evitar que el clic dentro del dropdown lo cierre
$("[data-dropdown-id]")
    .not("button")
    .on("click", function (e) {
        e.stopPropagation();
    });
