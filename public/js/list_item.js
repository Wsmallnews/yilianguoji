/**
 * 分页，搜索，排序，状态
 */
var list = {
	current_url : window.location.href + "?page=1",
	request_url : '',
	div_id : "#table_div",
	search_id : '',
	request_data : {},
	init : function(div_id,search_id){
		//设置列表id ，设置搜索框id
		list.div_id = (div_id !== undefined && div_id != null && div_id != '') ? div_id : list.div_id;
		list.search_id = (search_id !== undefined && search_id != null && search_id != '') ? search_id : list.div_id + "_search";

		//绑定分页
		$(list.div_id).on('click','li.page_num',function(){
	    	var url = $(this).find('a').attr('url');
	    	list.request_url = (url !== undefined && url != null && url != '') ? url : list.current_url;
			list.set_data();
	    	list.load_request();
	    });

		//绑定搜索
	    $("#search").on('click',function(){
	    	list.request_url = list.current_url;
			list.set_data();
	    	list.load_request();
	    })
	},
	set_data : function (data){
		list.request_data = data == undefined ? l.parseFormJson(list.search_id) : data;

		list.request_data['rows'] = 15;

	},

	load_request : function (){
		l.ajax({
            url:list.request_url,
            data:list.request_data,
            type:'get',
            success:function(r){
                if(r.error == 0){
                	$(list.div_id).html(r.data.html);
                }else{
                    alert('获取失败');
                }
            }
        });
	},
	reload : function () {
		list.request_url = list.current_url;

		list.set_data();
		list.load_request();
	},
	search_list : function (data) {
		list.request_url = list.current_url;

		list.set_data(data);
		list.load_request();
	},

}

var autoloadMethod = {
	init : function(){
		if($("#resetBtn").length > 0){
			$("#resetBtn").on('click',function(){
				l.location();
			});
		}
	}
}

autoloadMethod.init();
