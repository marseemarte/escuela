$("[data-search-bar-id]").on("click", function () {
    const searchBarId = $(this).data("search-bar-id");
    const searchBar = $(this);
    console.log("searchbar");
});
$("[data-search-item]").on("change", function () {
    console.log("searchitem");
});
$("[data-search-item]").on("DOMSubtreeModified", function () {
    console.log("searchitem");
});
