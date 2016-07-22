/**
 * 分页，搜索，排序，状态
 */
var list = {
	request_url : window.location.href + "?page=1",
	div_id : "#table_div",
	search_id : '#table_div_search',
	request_data : {},
	callback:undefined,
	init : function (){
		//初始化一些无法直接设置的属性
		list.callback = list.page_callback;
	},
	init_page : function(div_id,search_id,pageCB){
		//设置列表id ，设置搜索框id
		list.div_id = (div_id !== undefined && div_id != null && div_id != '') ? div_id : list.div_id;
		list.search_id = (search_id !== undefined && search_id != null && search_id != '') ? search_id : list.div_id + "_search";
		list.callback = pageCB !== undefined ? pageCB : list.callback;
		//绑定分页
		$(list.div_id).on('click','li.page_num',function(){
	    	var url = $(this).find('a').attr('url');
			url = url.replace('/?page','?page');

	    	list.request_url = (url !== undefined && url != null && url != '') ? url : list.request_url;
	    	list.load_request();
	    });

		//绑定搜索
	    $("#search").on('click',function(){
	    	list.load_request();
	    })
	},
	//重新加载页面
	reload : function (data,reloadCB) {
		if(reloadCB !== undefined){
			list.callback = reloadCB;
		}
		list.load_request(data);
	},

	search_list : function (data,listCB) {
		if(listCB !== undefined){
			list.callback = listCB;
		}
		list.load_request(data);
	},
	//设置数据
	set_data : function (data){
		list.request_data = data == undefined ? l.parseFormJson(list.search_id) : data;

		list.request_data['rows'] = 15;
	},
	//请求
	load_request : function (request_data){
		list.set_data(request_data);
		l.ajax({
            url:list.request_url,
            data:list.request_data,
            type:'get',
            success:function(r){
                list.callback(r);
            },error:function(){
				l.error('请求失败');
			}
        });
	},


	//默认success callback函数
	page_callback : function(r){
		if(r.error == 0){
			$(list.div_id).html(r.data.html);
		}else{
			l.error(r.info);
		}
	},
}
//初始化list
list.init();
