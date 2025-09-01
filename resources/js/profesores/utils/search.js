class SearchBuilder {
    constructor(searchBarId, data) {
        this.searchBarId = searchBarId;
        this.data = data;
        this.config = {
            events: "input textUpdate",
            logErrors: true,
            fieldMappings: {
                fullName: ["nombre", "apellido"],
            },
        };
    }

    // Callbacks
    onComplete(callback) {
        this.config.onComplete = callback;
        return this;
    }

    onStart(callback) {
        this.config.onStart = callback;
        return this;
    }

    onError(callback) {
        this.config.onError = callback;
        return this;
    }

    onEmpty(callback) {
        this.config.onEmpty = callback;
        return this;
    }

    // Configuración
    events(eventString) {
        this.config.events = eventString;
        return this;
    }

    // Establecer mapeos de campos personalizados( array )
    setFieldMappings(mappings) {
        this.config.fieldMappings = {
            ...this.config.fieldMappings,
            ...mappings,
        };
        return this;
    }

    // Ver errores
    enableLogging(enable = true) {
        this.config.logErrors = enable;
        return this;
    }

    // Metodo para normalizar texto
    _normalizeText(text) {
        return text
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .trim();
    }

    // Metodo principal
    initialize() {
        try {
            this._setupSearch();
            return this;
        } catch (error) {
            this._handleError(error, "initialization");
            return this;
        }
    }

    // metodos privados
    _setupSearch() {
        const handleSearch = (event) => {
            try {
                this._performSearch(event);
            } catch (error) {
                this._handleError(error, "search");
            }
        };

        $("[data-search-name]").on(this.config.events, handleSearch);
    }

    _filterSearchData(searchBarId, data) {
        const searchBar = $(`[data-search-bar-id="${searchBarId}"]`);
        const searchItems = searchBar.find("[data-search-name]");

        let results = [...data];

        // Filtrar los resultados en base a los inputs
        searchItems.each((index, element) => {
            const item = $(element);
            const searchName = item.data("search-name");
            const searchTermRaw = item.val()
                ? item.val().trim()
                : item.text().trim();
            const searchTerm = this._normalizeText(searchTermRaw);

            if (searchTerm) {
                // Separar el termino de búsqueda en palabras individuales
                const searchWords = searchTerm
                    .split(/\s+/)
                    .filter((word) => word.length > 0);

                results = results.filter((d) => {
                    // Determinar en que campos buscar
                    const fieldsToSearch = this.config.fieldMappings[
                        searchName
                    ] || [searchName];

                    // Si solo hay una palabra de busqueda, busqueda simple
                    if (searchWords.length === 1) {
                        return fieldsToSearch.some(
                            (fieldName) =>
                                d[fieldName] &&
                                this._normalizeText(d[fieldName]).includes(
                                    searchWords[0]
                                )
                        );
                    }

                    // Para multiples palabras, crear texto combinado de todos los campos relevantes
                    const combinedText = fieldsToSearch
                        .map((fieldName) =>
                            d[fieldName]
                                ? this._normalizeText(d[fieldName])
                                : ""
                        )
                        .filter((text) => text.length > 0)
                        .join(" ");

                    if (!combinedText) return false;

                    // Cada palabra del termino de búsqueda debe encontrarse en el texto combinado
                    return searchWords.every((word) =>
                        combinedText.includes(word)
                    );
                });
            }
        });

        return results;
    }

    _performSearch(event) {
        // Callback de inicio
        if (this.config.onStart) {
            this.config.onStart(this.searchBarId, event);
        }

        // Realizar búsqueda
        let results = this._filterSearchData(this.searchBarId, this.data);

        // Callback de resultados vacíos
        if (results.length === 0 && this.config.onEmpty) {
            this.config.onEmpty(this.searchBarId, results);
        }

        // Callback de completado
        if (this.config.onComplete) {
            this.config.onComplete(results, this.searchBarId);
        }
    }

    _handleError(error, context) {
        if (this.config.logErrors) {
            console.error(`SearchBuilder error in ${context}:`, error);
        }

        if (this.config.onError) {
            this.config.onError(error, context, this.searchBarId);
        }
    }

    // Metodos extra
    destroy() {
        $("[data-search-name]").off(this.config.events);
        return this;
    }

    updateData(newData) {
        if (!Array.isArray(newData)) {
            throw new Error("newData must be an array");
        }
        this.data = newData;
        return this;
    }

    trigger() {
        this._performSearch(null);
        return this;
    }
}

export { SearchBuilder };
