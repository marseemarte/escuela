function updateText(selector, newText) {
    const $element = $(selector);
    const oldText = $element.text();

    // Cambiar el texto
    $element.text(newText);

    // Disparar evento personalizado
    $element.trigger("textUpdate", {
        oldText: oldText,
        newText: newText,
        element: $element,
    });
}

function debounce(func, delay) {
    let timeoutId;
    return function (...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func.apply(this, args), delay);
    };
}

function searchHandler(searchBarId, data) {
    const searchBar = $(`[data-search-bar-id="${searchBarId}"]`);
    const searchItems = searchBar.find("[data-search-item]");

    searchItems.each(function () {
        const item = $(this);
        const itemText = item.text().toLowerCase();
    });
    console.log("searchHandler");
}

const data = [
    {
        id: 1,
        nombre: "Juan",
        apellido: "Pérez",
        asistencia: "justificado",
    },
    {
        id: 2,
        nombre: "María",
        apellido: "González",
        asistencia: "ausente",
    },
    {
        id: 3,
        nombre: "María",
        apellido: "González",
        asistencia: "presente",
    },
];
$("[data-search-bar-id]").on("click", function () {
    const searchBarId = $(this).data("search-bar-id");
    const searchBar = $(this);
    console.log("searchbar");
});
$("[data-search-item]").on(
    "input",
    debounce(function () {
        console.log("searchitem");
    }, 200)
);
$("[data-search-item]").on("textUpdate", function () {
    console.log("searchitem");
});
