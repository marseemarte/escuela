const sidebar = $("#sidebar-button");
sidebar.on("click", () => {
    if ($("#sidebar").hasClass("-translate-x-full")) {
        $("#sidebar").removeClass("-translate-x-full");
        $("#main").removeClass(
            "w-full sm:w-full md:w-full lg:w-full xl:w-full 2xl:w-full "
        );
    } else {
        $("#sidebar").addClass("-translate-x-full");
        $("#main").addClass(
            "w-full sm:w-full md:w-full lg:w-full xl:w-full 2xl:w-full "
        );
    }
});
