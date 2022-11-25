var popups = {
    example: $("#popup_example"),
};
const objPopups = Object.entries(popups);
function resize_popup(popup) {
    popup.height(popup.contents().height());
}
$(window).on("resize", function () {
    objPopups.forEach(([id, popup]) => {
        resize_popup(popup);
    });
})
objPopups.forEach(([id, popup]) => {
    objPopups.forEach(([id, popup]) => {
        popup.on("load", function () {
            setInterval(() => {
                resize_popup($(this));
            }, 1000);
        });
    });
});