import $ from "jquery";

const sidebar = $("#sidebar-button");
sidebar.on("click", () => {
    $("sidebar").hide;
});
