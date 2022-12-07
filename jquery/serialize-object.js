$j.fn.serializeObject = function() {
    var data = {};

    function buildInputObject(arr, val) {
        if (arr.length < 1) {
            return val;  
        }
        var objkey = arr[0];
        if (objkey.slice(-1) == "]") {
            objkey = objkey.slice(0,-1);
        }  
        var result = {};
        if (arr.length == 1){
            result[objkey] = val;
        } else {
            arr.shift();
            var nestedVal = buildInputObject(arr,val);
            result[objkey] = nestedVal;
        }
        return result;
    }

    function gatherMultipleValues( that ) {
        var final_array = [];
        $j.each(that.serializeArray(), function( key, field ) {
            if( field.name.indexOf('[]') < 0 ){
                final_array.push( field );
                return true;
            }

            var field_name = field.name.split('[]')[0];

            var has_value = false;
            $j.each( final_array, function( final_key, final_field ){
                if( final_field.name === field_name ) {
                    has_value = true;
                    final_array[ final_key ][ 'value' ].push( field.value );
                }
            });
            if( ! has_value ) {
                final_array.push( { 'name': field_name, 'value': [ field.value ] } );
            }
        });
        return final_array;
    }
    var final_array = gatherMultipleValues( this );

    $j.each(final_array, function() {
        var val = this.value;
        var c = this.name.split('[');
        var a = buildInputObject(c, val);
        $j.extend(true, data, a);
    });

    return data;
};