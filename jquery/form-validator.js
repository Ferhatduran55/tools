/**
 * 
 * @param returnType boolean
 * @return array|boolean
 * @description enter boolean value or use default value
 * 
 * @argument dataType string
 * @description
 *  This argument setting in the element property requires
 *  a string value that allows you to validate whatever
 *  type you want, regardless of the element type.
 * 
 */
$.fn.valid = function (returnType = false) {
    let tag = this.prop("tagName"), type, value = this.val();
    if (tag.toLowerCase() == "option") {
        type = "text";
    } else if (this.data("type") !== undefined) {
        type = this.data("type").toLowerCase();
    } else if (this.attr("type") === undefined) {
        type = this[0].type;
    } else {
        type = this.attr("type");
    }
    const types = {
        text: /^[a-z0-9]{0,}$/i,
        number: /^\d+$/,
        email: /(?:^|[^\wığüşöçĞÜŞÖÇİ])^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/,
        password: /^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=.*?[@$!%*?&_])[A-Za-z\d$@$!%*?&_].{6,})\S$/,
        phone: /^(([\+]?[(]?\d{0,3}[)]?)|([(]?[\+]?\d{0,3}[)]?))[-\s]?\d{3}[-\s]?\d{3}[-\s]?\d{4}$/,
        card: /^(?:3[47][0-9]{13})$/,
        "select-one": /[^0-9]/g,
        alphanum: /[^A-Za-z0-9 ]/,
        date: /^(0?[1-9]|1[012])[- /.](0?[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d$/,
        json: /^\{(\s|\n\s)*(("\w*"):(\s)*("\w*"|\d*|(\{(\s|\n\s)*(("\w*"):(\s)*("\w*(,\w+)*"|\d{1,}|\[(\s|\n\s)*(\{(\s|\n\s)*(("\w*"):(\s)*(("\w*"|\d{1,}))((,(\s|\n\s)*"\w*"):(\s)*("\w*"|\d{1,}))*(\s|\n)*})){1}(\s|\n\s)*(,(\s|\n\s)*\{(\s|\n\s)*(("\w*"):(\s)*(("\w*"|\d{1,}))((,(\s|\n\s)*"\w*"):(\s)*("\w*"|\d{1,}))*(\s|\n)*})?)*(\s|\n\s)*\]))((,(\s|\n\s)*"\w*"):(\s)*("\w*(,\w+)*"|\d{1,}|\[(\s|\n\s)*(\{(\s|\n\s)*(("\w*"):(\s)*(("\w*"|\d{1,}))((,(\s|\n\s)*"\w*"):(\s)*("\w*"|\d{1,}))*(\s|\n)*})){1}(\s|\n\s)*(,(\s|\n\s)*\{(\s|\n\s)*(("\w*"):(\s)*(("\w*"|\d{1,}))((,(\s|\n\s)*"\w*"):("\w*"|\d{1,}))*(\s|\n)*})?)*(\s|\n\s)*\]))*(\s|\n\s)*}){1}))((,(\s|\n\s)*"\w*"):(\s)*("\w*"|\d*|(\{(\s|\n\s)*(("\w*"):(\s)*("\w*(,\w+)*"|\d{1,}|\[(\s|\n\s)*(\{(\s|\n\s)*(("\w*"):(\s)*(("\w*"|\d{1,}))((,(\s|\n\s)*"\w*"):(\s)*("\w*"|\d{1,}))*(\s|\n)*})){1}(\s|\n\s)*(,(\s|\n\s)*\{(\s|\n\s)*(("\w*"):(\s)*(("\w*"|\d{1,}))((,(\s|\n\s)*"\w*"):(\s)*("\w*"|\d{1,}))*(\s|\n)*})?)*(\s|\n\s)*\]))((,(\s|\n\s)*"\w*"):(\s)*("\w*(,\w+)*"|\d{1,}|\[(\s|\n\s)*(\{(\s|\n\s)*(("\w*"):(\s)*(("\w*"|\d{1,}))((,(\s|\n\s)*"\w*"):(\s)*("\w*"|\d{1,}))*(\s|\n)*})){1}(\s|\n\s)*(,(\s|\n\s)*\{(\s|\n\s)*(("\w*"):(\s)*(("\w*"|\d{1,}))((,(\s|\n\s)*"\w*"):("\w*"|\d{1,}))*(\s|\n)*})?)*(\s|\n\s)*\]))*(\s|\n\s)*}){1}))*(\s|\n)*}$/,
        ipv4: /\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/,
        ipv6: /(([0-9a-fA-F]{1,4}:){7,7}[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,7}:|([0-9a-fA-F]{1,4}:){1,6}:[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,5}(:[0-9a-fA-F]{1,4}){1,2}|([0-9a-fA-F]{1,4}:){1,4}(:[0-9a-fA-F]{1,4}){1,3}|([0-9a-fA-F]{1,4}:){1,3}(:[0-9a-fA-F]{1,4}){1,4}|([0-9a-fA-F]{1,4}:){1,2}(:[0-9a-fA-F]{1,4}){1,5}|[0-9a-fA-F]{1,4}:((:[0-9a-fA-F]{1,4}){1,6})|:((:[0-9a-fA-F]{1,4}){1,7}|:)|fe80:(:[0-9a-fA-F]{0,4}){0,4}%[0-9a-zA-Z]{1,}|::(ffff(:0{1,4}){0,1}:){0,1}((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])|([0-9a-fA-F]{1,4}:){1,4}:((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9]))/,
        zip: /^[0-9]{5}(-[0-9]{4})?$/,
    };
    function startValidate(type, value) {
        typeList = Object.entries(types);
        type = typeList.find(item => item[0] === type)[1];
        if (type === null) {
            type = tag;
        }
        let control = value.match(type);
        if (control) {
            return true;
        } else {
            return false;
        }
    }
    if (returnType) {
        return [startValidate(type, value), type];
    } else {
        return startValidate(type, value);
    }
};