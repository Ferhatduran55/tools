const { exit } = require("process");
function getEnv(properties, isInt = false) {
    var output;
    var arr = Object.entries(process.env);
    arr.forEach(element => {
        if (Array.isArray(element)) {
            let num = 0;
            element.forEach(element2 => {
                if (element2 == properties || num >= 1) {
                    num += 1;
                    if (num == 2) {
                        if (isInt) {
                            output = parseInt(element2);
                            exit;
                        } else {
                            output = element2;
                            exit;
                        }
                    }
                }
            });
        }
    });
    return output;
}