const sidebar = $("#sidebar-button");
const screenWidth = $(window).width();
const smallScreenThreshold = 768;
function closeSidebar() {
    $("#sidebar").addClass("-translate-x-full");
    $("#sidebarHeader").addClass(
        "w-[9vh] sm:w-[10vh] md:w-[10vh] lg:w-[9vh] xl:w-[8vh] 2xl:w-[7vh] justify-center"
    );
    $("#sidebarHeader").removeClass(
        "w-[50vw] sm:w-[33vw] md:w-[27vw] lg:w-[23vw] xl:w-[20vw] 2xl:w-[16vw] justify-between"
    );
    $("#sidebarHeader").children("a").addClass("hidden");
    $("#main").addClass(
        "w-full sm:w-full md:w-full lg:w-full xl:w-full 2xl:w-full "
    );
}
function openSidebar() {
    $("#sidebar").removeClass("-translate-x-full");
    $("#sidebarHeader").addClass(
        "w-[50vw] sm:w-[33vw] md:w-[27vw] lg:w-[23vw] xl:w-[20vw] 2xl:w-[16vw] justify-between"
    );
    $("#sidebarHeader").removeClass(
        "w-[9vh] sm:w-[10vh] md:w-[10vh] lg:w-[9vh] xl:w-[8vh] 2xl:w-[7vh] justify-center"
    );
    $("#sidebarHeader").children("a").removeClass("hidden");
    $("#main").removeClass(
        "w-full sm:w-full md:w-full lg:w-full xl:w-full 2xl:w-full "
    );
}
if (screenWidth < smallScreenThreshold) {
    closeSidebar();
}
sidebar.on("click", () => {
    if ($("#sidebar").hasClass("-translate-x-full")) {
        openSidebar();
    } else {
        closeSidebar();
    }
});
