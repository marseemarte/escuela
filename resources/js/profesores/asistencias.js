import { SearchBuilder } from "./utils/search";
import { updateData } from "./utils/helpers";
import setupDropdowns from "./components/dropdown";

let data = [
    {
        id: 1,
        nombre: "Juan",
        apellido: "Pérez",
        valor: "justificado",
    },
    {
        id: 2,
        nombre: "María",
        apellido: "González",
        valor: "ausente",
    },
    {
        id: 3,
        nombre: "Marta",
        apellido: "Ortega",
        valor: "presente",
    },
];
const searchBarId = "tomarAsistencias";

const searchAsistencias = new SearchBuilder(searchBarId, data)
    .onComplete((results) => {
        console.log("Resultados de la búsqueda:", results);
        updateAsistenciasTable(results);
    })
    .initialize();

const createTableRow = (
    id,
    nombre,
    apellido,
    valorSeleccionado,
    textoSeleccionado
) => {
    return `
        <tr class="bg-white border-b border-gray-200">
            <td class="px-2.5 py-4 md:px-6">
                ${id}
            </td>
            <td class="px-2.5 py-4 md:px-6">
                ${nombre}
            </td>
            <td class="px-2.5 py-4 md:px-6">
                ${apellido}
            </td>
            <td class="px-2.5 py-4 md:px-6">
                <div class="w-full flex justify-center">
                    <div class="relative w-full">
                        <button data-dropdown-button-id="${id}" class="w-full inline-flex justify-center items-center text-white focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 bg-gray-600 hover:bg-gray-700 focus:ring-gray-300">
                            <span class="selectedOptionText truncate flex-1 text-center">${textoSeleccionado}</span>
                            <span class="selectedOptionValue hidden">${valorSeleccionado}</span>
                            <svg class="h-[0.8vw] w-[0.8vw] ml-3 flex-shrink-0" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"></path>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div data-dropdown-id="${id}" class="hidden absolute top-full left-0 mt-2 w-full bg-white divide-y divide-gray-100 rounded-lg shadow-lg border border-gray-200 z-10">
                            <ul class="py-2 text-sm text-gray-700">
                                <li>
                                    <button class="block px-4 py-2 hover:bg-gray-100 w-full cursor-pointer" data-option-id="0">Presente</button>
                                    <span class="optionValue hidden" data-option-value-id="0">presente</span>
                                </li>
                                <li>
                                    <button class="block px-4 py-2 hover:bg-gray-100 w-full cursor-pointer" data-option-id="1">Ausente</button>
                                    <span class="optionValue hidden" data-option-value-id="1">ausente</span>
                                </li>
                                <li>
                                    <button class="block px-4 py-2 hover:bg-gray-100 w-full cursor-pointer" data-option-id="2">Justificado</button>
                                    <span class="optionValue hidden" data-option-value-id="2">justificado</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    `;
};

function setDropdownColor(dropdownButton, option = false) {
    let texto;
    if (option == false) {
        texto = dropdownButton.find(".selectedOptionText").text();
    } else {
        texto = option.text();
    }

    const presenteButton = "bg-blue-700 hover:bg-blue-800 focus:ring-blue-300";
    const ausenteButton =
        "bg-yellow-700 hover:bg-yellow-800 focus:ring-yellow-300";
    const justificadoButton =
        "bg-gray-600 hover:bg-gray-700 focus:ring-gray-300";
    const todosButton = "bg-green-500 hover:bg-green-600 focus:ring-green-400";
    const defaultButton = "bg-gray-400 hover:bg-gray-500 focus:ring-gray-300";

    dropdownButton.removeClass(
        `${presenteButton} ${ausenteButton} ${justificadoButton} ${todosButton} ${defaultButton}`
    );

    switch (texto) {
        case "Presente":
            dropdownButton.addClass(presenteButton);
            break;
        case "Ausente":
            dropdownButton.addClass(ausenteButton);
            break;
        case "Justificado":
            dropdownButton.addClass(justificadoButton);
            break;
        case "Todos":
            dropdownButton.addClass(todosButton);
            break;
        default:
            dropdownButton.addClass(defaultButton);
            break;
    }
}

function setupDropdownsAsistencias(parent = document) {
    const container = $(parent);
    setupDropdowns(parent);
    container.off("click.dropdown-asistencias");

    // Opciones dropdown
    container.on(
        "click.dropdown-asistencias",
        "[data-dropdown-id] button[data-option-id]",
        function (e) {
            e.stopPropagation();
            const optionButton = $(this);
            const optionId = optionButton.data("option-id");
            const optionValue = optionButton
                .next(`span[data-option-value-id="${optionId}"]`)
                .text();

            const dropdown = optionButton.closest("[data-dropdown-id]");
            const dropdownId = dropdown.data("dropdown-id");

            // Actualizar data
            data = updateData(data, dropdownId, optionValue, "asistencias");

            searchAsistencias.updateData(data);
            setDropdownColor($(`[data-dropdown-button-id='${dropdownId}']`));

            console.log(`data actualizada: (${optionValue}) id ${dropdownId}`);
            console.log(data);
        }
    );
}
// Inicializar
setupDropdownsAsistencias();

function updateAsistenciasTable(data) {
    const tbody = $("table[data-search-id='tomarAsistencias'] tbody");

    tbody.empty();
    data.forEach((element) => {
        const [primera, ...resto] = element.valor;
        const textoSeleccionado = primera.toUpperCase() + resto.join("");
        tbody.append(
            createTableRow(
                element.id,
                element.nombre,
                element.apellido,
                element.valor,
                textoSeleccionado
            )
        );
        setDropdownColor($(`[data-dropdown-button-id='${element.id}']`));
    });
}

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
