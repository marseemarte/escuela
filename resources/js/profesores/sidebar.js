const sidebar = $("#sidebar-button");
sidebar.on("click", () => {
    if ($("#sidebar").hasClass("-translate-x-full")) {
        $("#sidebar").removeClass("-translate-x-full");
        $("#main").removeClass("w-full");
    } else {
        $("#sidebar").addClass("-translate-x-full");
        $("#main").addClass("w-full");
    }
});
