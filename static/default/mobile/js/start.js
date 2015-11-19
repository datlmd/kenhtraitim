$(window).load(function() {
    $('#slider').nivoSlider();
});
/**
 * author dungdv3
 * Check menu is actived
 * @param string objId :id element is highlight
 * @returns nothing
 */
function activeMenu(objId) {
    liMenu = $(".nav-list li a");
    for (i = 0; i < liMenu.length; i++) {
        if (liMenu[i].id == objId) {
            $("#" + liMenu[i].id).addClass("active");
            break;
        }
    }
}