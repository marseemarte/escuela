import { SearchBuilder } from "./utils/search";
import { updateData } from "./utils/helpers";
import setupDropdowns from "./components/dropdown";

const baseDataTomar = [
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
let dataTomar = baseDataTomar;

const baseDataTotal = [
    {
        id: 1,
        nombre: "Juan",
        apellido: "Pérez",
        valor: "75%",
    },
    {
        id: 2,
        nombre: "María",
        apellido: "González",
        valor: "40%",
    },
    {
        id: 3,
        nombre: "Marta",
        apellido: "Ortega",
        valor: "60%",
    },
];
let dataTotal = baseDataTotal;

const searchBarIdTomar = "tomarAsistencias";
const searchBarIdTotal = "totalAsistencias";

const searchAsistenciasTomar = new SearchBuilder(searchBarIdTomar, dataTomar)
    .onComplete((results) => {
        console.log("Resultados de la búsqueda tomar:", results);
        updateAsistenciasTable(results);
    })
    .initialize();

const searchAsistenciasTotal = new SearchBuilder(searchBarIdTotal, dataTotal)
    .onComplete((results) => {
        console.log("Resultados de la búsqueda total:", results);
        updateAsistenciasTable(results, false);
    })
    .initialize();

const createTableRowTotal = (id, nombre, apellido, porcentaje) => {
    const colorClass = porcentaje >= "70%" ? "text-green-600" : "text-red-600";
    return `
        <tr class="bg-white border-b border-gray-200 min-h-[52px] h-auto align-middle w-full md:w-auto">
            <td class="whitespace-nowrap px-2 py-3 md:table-cell w-1/10 md:w-auto">
                ${id}
            </td>
            <td class="whitespace-nowrap px-2 py-3 md:table-cell w-3/10 md:w-auto">
                ${nombre}
            </td>
            <td class="whitespace-nowrap px-2 py-3 md:table-cell w-3/10 md:w-auto">
                ${apellido}
            </td>
            <td class="whitespace-nowrap px-2 py-3 md:table-cell w-3/10 md:w-auto">
                <span class="font-semibold ${colorClass}">
                    ${porcentaje}
                </span>
            </td>
        </tr>
    `;
};

const createTableRowTomar = (
    id,
    nombre,
    apellido,
    valorSeleccionado,
    textoSeleccionado
) => {
    return `
        <tr class="bg-white border-b border-gray-200 min-h-[52px] h-auto align-middle w-full md:w-auto ">
            <td class="whitespace-nowrap px-2 py-3 md:table-cell w-1/12 md:w-auto">
                ${id}
            </td>
            <td class="whitespace-nowrap px-2 py-3 md:table-cell w-3/12 md:w-auto">
                ${nombre}
            </td>
            <td class="whitespace-nowrap px-2 py-3 md:table-cell w-3/12 md:w-auto">
                ${apellido}
            </td>
            <td class="whitespace-nowrap px-2 py-3 md:table-cell w-5/12 md:w-auto md:px-4">
                <div class="w-full flex justify-center">
                    <div class="relative w-full">
                        <button data-dropdown-button-id="${id}" class="w-full inline-flex justify-center items-center text-white focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 bg-gray-600 hover:bg-gray-700 focus:ring-gray-300 ">
                            <span class="selectedOptionText truncate flex-1 text-center">${textoSeleccionado}</span>
                            <span class="selectedOptionValue hidden">${valorSeleccionado}</span>
                            <svg class="h-3.5 w-3.5 md:h-[0.8vw] md:w-[0.8vw] ml-3 flex-shrink-0 transition-all duration-200" fill="none" viewBox="0 0 10 6">
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

function setDropdownColor(dropdownButton, valorSeleccionado = null) {
    let valor = valorSeleccionado;
    if (!valor) {
        // Si no se pasa el valor, intentar obtenerlo del span hidden
        valor = dropdownButton.find(".selectedOptionValue").text();
    }

    const presenteButton = "bg-blue-700 hover:bg-blue-800 focus:ring-blue-300";
    const ausenteButton =
        "bg-yellow-700 hover:bg-yellow-800 focus:ring-yellow-300";
    const justificadoButton =
        "bg-gray-600 hover:bg-gray-700 focus:ring-gray-300";
    const aprobadoButton =
        "bg-green-500 hover:bg-green-600 focus:ring-green-400";
    const desaprobadoButton = "bg-red-500 hover:bg-red-600 focus:ring-red-400";
    const todosButton = "bg-green-500 hover:bg-green-600 focus:ring-green-400";
    const defaultButton = "bg-gray-400 hover:bg-gray-500 focus:ring-gray-300";

    // Remover todas las clases de color
    dropdownButton.removeClass(
        "bg-blue-700 hover:bg-blue-800 focus:ring-blue-300 bg-yellow-700 hover:bg-yellow-800 focus:ring-yellow-300 bg-gray-600 hover:bg-gray-700 focus:ring-gray-300 bg-green-500 hover:bg-green-600 focus:ring-green-400 bg-red-500 hover:bg-red-600 focus:ring-red-400 bg-gray-400 hover:bg-gray-500 focus:ring-gray-300"
    );

    switch (valor) {
        case "presente":
            dropdownButton.addClass(presenteButton);
            break;
        case "ausente":
            dropdownButton.addClass(ausenteButton);
            break;
        case "justificado":
            dropdownButton.addClass(justificadoButton);
            break;
        case "aprobado":
            dropdownButton.addClass(aprobadoButton);
            break;
        case "desaprobado":
            dropdownButton.addClass(desaprobadoButton);
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
            dataTomar = updateData(
                dataTomar,
                dropdownId,
                optionValue,
                "asistencias"
            );

            searchAsistenciasTomar.updateData(dataTomar);
            setDropdownColor($(`[data-dropdown-button-id='${dropdownId}']`));

            console.log(`data actualizada: (${optionValue}) id ${dropdownId}`);
            console.log(dataTomar);
        }
    );
}
// Inicializar
setupDropdownsAsistencias();

// Botones rápidos: P, A, J
$(document).on("click", ".quick-set-btn", function () {
    const tipo = $(this).data("tipo");
    let valor = "presente";
    if (tipo === "a") {
        valor = "ausente";
    } else if (tipo === "j") {
        valor = "justificado";
    }
    // Actualizar todos los registros
    dataTomar = dataTomar.map((item) => ({ ...item, valor: valor }));
    searchAsistenciasTomar.updateData(dataTomar);
    updateAsistenciasTable(dataTomar);
});

function updateAsistenciasTable(data, asistenciaTomar = true) {
    if (!asistenciaTomar) {
        const tbody = $("table[data-search-id='totalAsistencias'] tbody");

        tbody.empty();
        data.forEach((element) => {
            // Para asistencias totales, mostrar el porcentaje directamente
            tbody.append(
                createTableRowTotal(
                    element.id,
                    element.nombre,
                    element.apellido,
                    element.valor
                )
            );
        });
        return;
    }
    const tbody = $("table[data-search-id='tomarAsistencias'] tbody");

    tbody.empty();
    data.forEach((element) => {
        const [primera, ...resto] = element.valor;
        const textoSeleccionado = primera.toUpperCase() + resto.join("");
        tbody.append(
            createTableRowTomar(
                element.id,
                element.nombre,
                element.apellido,
                element.valor,
                textoSeleccionado
            )
        );
        // Usar setTimeout para asegurar que el DOM esté actualizado antes de aplicar colores
        setTimeout(() => {
            setDropdownColor(
                $(`[data-dropdown-button-id='${element.id}']`),
                element.valor
            );
        }, 0);
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
