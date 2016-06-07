var l = {
	ajax:function(params){
		var defaults = {
			url : '',
			data : {},
			dataType : 'JSON',
			type:'post',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			success:function(){},
			error:function(){}
		}

		$.extend(defaults, params);

		defaults['data']['timeStamp'] = (new Date()).getTime();

		$.ajax(defaults);
	},
	parseFormJson : function(frm) {
		var o = {};
		var a = $(frm).serializeArray();
		$.each(a, function () {
			if (o[this.name] !== undefined) {
				if (!o[this.name].push) {
					o[this.name] = [o[this.name]];
				}
				o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			}
		});
		return o;
	},
	error : function(msg){
		alert(msg);
	},
	success : function(msg){
		alert(msg);
	},
	location : function(url){
		if(url != undefined){
			window.location.href = url;
			return;
		}
		window.history.go(-1);
	}

}
