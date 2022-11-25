const data = {
    your_element_selector: "#removeButton",
    your_event_type: "click"
};
var { your_element_selector, your_event_type } = data;
$("body").on(`${your_event_type}`, `${your_element_selector}`, function () {
    alert(`${your_element_selector} -> ${your_event_type}`);
});