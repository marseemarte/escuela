//Funcion para actualizar el texto de un elemento y ejecutar el evento --textUpdate--
function updateText(selector, newText) {
    const $element = $(selector);
    const oldText = $element.text();

    // Cambiar el texto
    $element.text(newText);

    // Disparar el evento
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
function renameProperty(array, oldProperty, newProperty) {
    return array.map((item) => {
        const { [oldProperty]: value, ...rest } = item;
        return {
            ...rest,
            [newProperty]: value,
        };
    });
}
function transformData(data) {
    return data.map((item) => ({
        ...item,
        estado: item.asistencia,
    }));
}

export { updateText, debounce, renameProperty, transformData };
