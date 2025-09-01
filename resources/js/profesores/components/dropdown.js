import { updateText } from "../utils/helpers";
export default function setupDropdowns(parent = document) {
    const container = $(parent);

    // Remover event handlers existentes para evitar duplicación
    container.off("click.dropdown");

    container.on(
        "click.dropdown",
        "button[data-dropdown-button-id]",
        function (e) {
            e.stopPropagation();
            const dataId = $(this).data("dropdown-button-id");
            const dropdown = $('[data-dropdown-id="' + dataId + '"]').not(
                "button"
            );

            // Cerrar otros dropdowns
            $("[data-dropdown-id]")
                .not("button")
                .not(dropdown)
                .addClass("hidden");

            // Toggle el dropdown actual
            dropdown.toggleClass("hidden");

            console.log(
                `Dropdown toggled in ${
                    parent === document ? "document" : parent
                }`
            );
        }
    );

    container.on(
        "click.dropdown",
        "[data-dropdown-id] button[data-option-id]",
        function (e) {
            e.stopPropagation();
            const optionButton = $(this);
            const optionText = optionButton.text();
            const optionId = optionButton.data("option-id");
            const optionValue = optionButton
                .next(`span[data-option-value-id="${optionId}"]`)
                .text();

            const dropdown = optionButton.closest("[data-dropdown-id]");
            const dropdownId = dropdown.data("dropdown-id");
            const dropdownButton = $(
                `button[data-dropdown-button-id="${dropdownId}"]`
            );

            // Actualizar texto y valor
            dropdownButton.find(".selectedOptionText").text(optionText);
            updateText(
                dropdownButton.find(".selectedOptionValue"),
                optionValue
            );

            dropdown.addClass("hidden");

            console.log(
                `Option clicked in ${parent === document ? "document" : parent}`
            );
        }
    );

    container.on("click.dropdown", "[data-dropdown-id]", function (e) {
        e.stopPropagation();
        console.log("Dropdown clicked and not closed");
    });

    // Setup global click handler solo una vez
    if (!$(document).data("dropdown-global-setup")) {
        $(document).on("click.dropdown-global", function () {
            $("[data-dropdown-id]").not("button").addClass("hidden");
            console.log("Document clicked, dropdowns closed");
        });

        $(document).data("dropdown-global-setup", true);
    }
}
