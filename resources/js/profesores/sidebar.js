const sidebar = $("#sidebar-button");
let screenWidth = $(window).width();
const smallScreenThreshold = 768;
function closeSidebar() {
    if (screenWidth <= smallScreenThreshold) {
        $("#darkenMain").addClass("hidden");
    }
    $("#sidebar").addClass("-translate-x-full");
    $("#sidebarHeader").addClass(
        "w-[9vh] sm:w-[10vh] md:w-[10vh] lg:w-[9vh] xl:w-[8vh] 2xl:w-[7vh] justify-center"
    );
    $("#sidebarHeader").removeClass(
        "w-[60vw] sm:w-[40vw] md:w-[27vw] lg:w-[23vw] xl:w-[20vw] 2xl:w-[16vw] justify-between absolute"
    );
    $("#sidebarHeader").children("a").addClass("hidden");
    $("#main").addClass(
        "w-full sm:w-full md:w-full lg:w-full xl:w-full 2xl:w-full "
    );
}
function openSidebar() {
    if (screenWidth <= smallScreenThreshold) {
        $("#darkenMain").removeClass("hidden");
    }
    $("#sidebar").removeClass("-translate-x-full");
    $("#sidebarHeader").addClass(
        "w-[60vw] sm:w-[40vw] md:w-[27vw] lg:w-[23vw] xl:w-[20vw] 2xl:w-[16vw] justify-between absolute"
    );
    $("#sidebarHeader").removeClass(
        "w-[9vh] sm:w-[10vh] md:w-[10vh] lg:w-[9vh] xl:w-[8vh] 2xl:w-[7vh] justify-center"
    );
    $("#sidebarHeader").children("a").removeClass("hidden");
    $("#main").removeClass(
        "w-full sm:w-full md:w-full lg:w-full xl:w-full 2xl:w-full "
    );
}
$(window).on("resize", () => {
    screenWidth = $(window).width();
    if (screenWidth <= smallScreenThreshold) {
        closeSidebar();
        $("#darkenMain").on("click", () => {
            closeSidebar();
        });
    } else {
        $("#darkenMain").addClass("hidden");
    }
});
if (screenWidth <= smallScreenThreshold) {
    closeSidebar();
    $("#darkenMain").on("click", () => {
        closeSidebar();
    });
} else {
    $("#darkenMain").addClass("hidden");
}
sidebar.on("click", () => {
    if ($("#sidebar").hasClass("-translate-x-full")) {
        openSidebar();
    } else {
        closeSidebar();
    }
});
