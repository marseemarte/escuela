$("button[data-dropdown-button-id]").on("click", function (e) {
    e.stopPropagation();
    const dataId = $(this).data("dropdown-button-id");
    const $dropdownButton = $(this);
    const $dropdown = $('[data-dropdown-id="' + dataId + '"]').not("button");
    const $options = $dropdown.find("button");

    $options.on("click", function () {
        const texto = $(this).text();
        const presenteButton =
            "bg-blue-700 hover:bg-blue-800 focus:ring-blue-300";
        const ausenteButton =
            "bg-yellow-700 hover:bg-yellow-800 focus:ring-yellow-300";
        const justificadoButton =
            "bg-gray-700 hover:bg-gray-800 focus:ring-gray-300";

        $dropdownButton.removeClass(
            `${presenteButton} ${ausenteButton} ${justificadoButton}`
        );

        switch (texto) {
            case "Presente":
                $dropdownButton.addClass(presenteButton);
                break;
            case "Ausente":
                $dropdownButton.addClass(ausenteButton);
                break;
            case "Justificado":
                $dropdownButton.addClass(justificadoButton);
                break;
            default:
                $dropdownButton.find("span").text("ERROR");
                break;
        }
    });
});
$(".tab").on("click", function () {
    $(".tab")
        .removeClass("text-blue-600 bg-[#eeeded] border-blue-600 active")
        .addClass("hover:text-blue-600 hover:bg-gray-100 border-transparent");
    $(this)
        .removeClass("hover:text-blue-600 hover:bg-gray-100 border-transparent")
        .addClass("text-blue-600 bg-[#eeeded] border-blue-600 active");
    const tabNumber = $(this).data("tab");

    $(".tab-content").addClass("hidden");
    $(`.tab-content[data-tab-content='${tabNumber}']`).removeClass("hidden");
});
