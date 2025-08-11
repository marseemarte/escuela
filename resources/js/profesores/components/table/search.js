$("[data-search-bar-id]").on("change", function () {
    const searchBarId = $(this).data("search-bar-id");
    const searchBar = $(this);
    console.log("searchbar");
    $("[data-search-item]").on("change", function () {
        console.log("searchitem");
    });
});
