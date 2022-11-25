function isset(obj, nested) {
    var dub = obj
    var isset = false
    if (typeof (obj) != "undefined" && typeof (nested) != "undefined") {
        var arr = nested.split('=>');
        for (var k in arr) {
            var key = arr[k];
            if (typeof (dub[key]) == "undefined") {
                isset = false;
                break;
            }
            dub = dub[key];
            isset = dub
        }
    }
    return isset;
}