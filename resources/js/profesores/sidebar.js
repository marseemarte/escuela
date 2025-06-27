const sidebar = $("#sidebar-button");
sidebar.on("click", () => {
    console.log("hola");
    if ($("#sidebar").hasClass("hidden")) {
        $("#sidebar").removeClass("hidden");
    } else {
        $("#sidebar").addClass("hidden");
    }
});
