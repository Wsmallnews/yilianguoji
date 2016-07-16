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
			beforeSend: function(){
				$('body').css({'cursor': 'wait'});
				$('.loading').show();
			},
			success:function(){},
			error:function(){},
			complete:function(){
				$('body').css({'cursor': 'auto'});
				$('.loading').hide();
			}
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
		var id = "#error_msg_modal";
		$(id).find('.error_msg').html(msg);

		l.showModal(id,{
			show:true,
	        backdrop: 'static',
	        keyboard: false
		});
	},
	success : function(msg){
		var id = "#success_msg_modal";
		$(id).find('.success_msg').html(msg);

		l.showModal(id,{
			show:true,
	        backdrop: true,
	        keyboard: true
		});
	},
	// confirm : function(msg){
	// 	if(confirm(msg)){
	// 		return true;
	// 	}else{
	// 		return false;
	// 	}
	// },
	confirm : function(oper_ids,startCB,confirmCB){
		var defaults = {
			modal : "#myModal",
	        big_id : "#table_div",
	        little_id : ".oper_btn",
	        confirm_id : "#confirm"
		}

		$.extend(defaults, oper_ids);

		$(defaults.big_id).on('click',defaults.little_id,function(){
			if(startCB != undefined){
				startCB(this);
			}

			l.showModal(defaults.modal,{
				show:true,
		        backdrop: 'static',
		        keyboard: false
			})
		})

		$(defaults.confirm_id).on('click',function(){
			if(confirmCB != undefined){
				confirmCB();
			}
		})
	},
	showModal : function(id,params){
		var defaults = {
			show:false,
			backdrop: true,	//‘static’指定静态背景不点击关闭模态（点击背景不关闭）
			keyboard: true	//点击esc 关闭
		}

		$.extend(defaults, params);

		$(id).modal(defaults);
	},
	hideModel : function (id){
		$(id).modal('hide');
	},
	location : function(url){
		if(url != undefined){
			window.location.href = url;
			return;
		}
		window.history.go(-1);
	},
	reload : function(){
		window.location.reload();
		return;
	}

}

var autoloadMethod = {
	init : function(){
		autoloadMethod.resetBtn();
	},
	resetBtn : function(){
		if($("#resetBtn").length > 0){
			$("#resetBtn").on('click',function(){
				l.location();
			});
		}
	}
}

autoloadMethod.init();
