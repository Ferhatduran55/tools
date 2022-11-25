$.ajax({
    url: "", //page url
    type: "", //post or get
    dataType: "", //json, html, text..
    data: {}, //{ value,.. <- variables or values} <- array or any value -> value
    success: function () {
        //code..	
    },
    error: function (e) {
        console.log(e);
    }
});