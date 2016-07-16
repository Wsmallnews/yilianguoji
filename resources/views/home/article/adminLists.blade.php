<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <meta name="description" content="">
    <meta name="author" content="">

    <title>资讯列表 - {{$l_web['web_name']}}</title>
    <style>
        .modal-header{border:none}
        .modal-footer{border:none}
        .huge{font-size: 30px;}
        .chat-icon{padding: 10px;border-radius: 50%;background-color: #f0ad4e;color: #FFFFFF;}
        .chat .chat-body{color:#333333;}
        .chat a:hover{text-decoration:none;}
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->

        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">资讯列表</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            资讯列表
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" id="list_div">
                            <div id="search_div">
                                <form class="form-inline" id="table_div_search">
                                    <div class="form-group">
                                        <label>标题</label>
                                        <input type="text" class="form-control" name="keyword" placeholder="关键字" />
                                    </div>

                                    <!-- <div class="form-group">
                                        <label>状态</label>
                                        <select class="form-control" name="status">
                                            <option value="all">全部</option>
                                            <option value="0">未处理</option>
                                            <option value="1">同意</option>
                                            <option value="-1">驳回</option>
                                        </select>
                                    </div> -->
                                    <button type="button" class="btn btn-primary" id="search">搜索</button>
                                </form>
                            </div>
                            <div id="table_div">
                                @if($l_user->super_man && Route::currentRouteName() == 'articleListAdmin')
                                @include('home.article.adminLi')
                                @else
                                @include('home.article.li')
                                @endif
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <div class="modal fade" id="myModal" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="title"></h4>
                </div>
                <div class="modal-body">
                    <form id="confirm_form">

                        <div class="form-group" id="fail_msg">
                            <label class="control-label" for="">驳回原因</label>
                            <textarea name="fail_msg" class="form-control" style="width:100%;height:100%;"></textarea>
                        </div>

                        <input type="hidden" name="id" value="0" />
                        <input type="hidden" name="status" value="0" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="confirm">确认</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    @include('home.includes.loadjs')
    <script type="text/javascript" >
    list.init_page();


    </script>
    @include('home.includes.footer')
</body>

</html>
