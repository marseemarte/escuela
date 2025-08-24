import { updateText } from "../utils/helpers";
$("button[data-dropdown-button-id]").on("click", function (e) {
    e.stopPropagation();
    const dataId = $(this).data("dropdown-button-id");
    const dropdownButton = $(this);
    const dropdown = $('[data-dropdown-id="' + dataId + '"]').not("button");
    const options = dropdown.find("button");

    function unbindEvents(element = null) {
        switch (element) {
            case "document":
                $(document).off("click");
                return;
            case "options":
                options.off("click");
                return;
            case "dropdown":
                dropdown.off("click");
                return;
            default:
                $(document).off("click");
                options.off("click");
                dropdown.off("click");
                return;
        }
    }
    // Cerrar otros dropdowns
    $("[data-dropdown-id]").not("button").not(dropdown).addClass("hidden");

    // Toggle el dropdown actual
    if (dropdown.hasClass("hidden")) {
        unbindEvents();
    }
    dropdown.toggleClass("hidden");

    options.on("click", function () {
        const optionText = $(this).text();
        const optionId = $(this).data("option-id");
        const optionValue = $(this)
            .next(`span[data-option-value-id="${optionId}"]`)
            .text();
        dropdownButton.find(".selectedOptionText").text(optionText);
        updateText(dropdownButton.find(".selectedOptionValue"), optionValue);
        dropdown.addClass("hidden");

        // Desactivar eventos para no crearlos infinitamente
        unbindEvents();

        //debugging
        console.log("Option clicked");
    });

    dropdown.on("click", function (e) {
        e.stopPropagation();

        //debugging
        console.log("Dropdown clicked and not closed");
    });
    // Cerrar dropdown al hacer clic fuera
    $(document).on("click", function () {
        dropdown.addClass("hidden");
        // Desactivar eventos para no crearlos infinitamente
        unbindEvents();

        //debugging
        console.log("Document clicked, dropdown closed");
    });
});
