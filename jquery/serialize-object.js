$.fn.serializeToObject = function() {
	var serial_array = this.serializeArray();
	var serial_object = {};
	$(serial_array).each(function() {
		if( !serial_object[this.name] )
		{
			serial_object[this.name] = this.value;
		}
	});
	return serial_object;
}