<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <meta name="description" content="">
    <meta name="author" content="">

    <title>用户列表 - {{$l_web['web_name']}}</title>

</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->

        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">会员列表</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            我的会员列表
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" id="list_div">
                            <div id="search_div">
                                <form class="form-inline" id="table_div_search">
                                    <div class="form-group">
                                        <label>用户名</label>
                                        <input type="text" class="form-control" name="keyword" placeholder="关键字">
                                    </div>
                                    <button type="button" class="btn btn-primary" id="search">搜索</button>
                                </form>
                            </div>
                            <div id="table_div">
                                @include('home.user.li')
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
                    <form id="reset_form">
                        <div class="form-group" id="password">
                            <label class="control-label" for="">新密码</label>
                            <input type="password" class="form-control" name="password" value=""/>
                        </div>

                        <div class="form-group" id="conf_password">
                            <label class="control-label" for="">确认密码</label>
                            <input type="password" class="form-control" name="conf_password" value=""/>
                        </div>
                        <input type="hidden" name="id" value="0" />
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

    list.init();

    $("#table_div").on('click','.active_btn',function(){
        var id = $(this).parents('tr').attr('user_id');
        if(confirm('确定要激活该用户吗？激活将消耗600 亿联币！')){
            l.ajax({
                url:"{{URL::to('home/userActive')}}",
                data:{'id':id},
                type:'get',
                success:function(r){
                    if(r.error == 0){
                        l.success('操作成功');
                        list.reload();
                        return;
                    }
                    l.error('操作失败');
                    return;
                }
            });
        }
        return false;
    });


    $('#myModal').modal({
        show:false
    });

    $("#table_div").on('click',".reset_user_btn",function(){
        var id = $(this).parents('tr').attr('user_id');
        var user_name = $(this).parents('tr').find('.user_name').html();

        var msg = '正在为“'+user_name+'”重置密码';

        $('#title').html(msg);
        $('#reset_form').find('input[name=id]').val(id);
        $('#myModal').modal('show');
    });

    $("#confirm").on('click',function(){
        var data = l.parseFormJson("#reset_form");

        if(data.password == ''){
            $("#password").addClass('has-error');
            return false;
        }else if(data.password != data.conf_password){
            $("#conf_password").addClass('has-error');
            return false;
        }

        l.ajax({
            url:"{{URL::to('home/resetPass')}}",
            data:data,
            type:'get',
            success:function(r){
                $('#myModal').modal('hide');
                if(r.error == 0){
                    l.success('重置成功');
                    list.reload();
                    return;
                }
                l.error(r.info);
                return;
            }
        });

        return false;
    })

    </script>

</body>

</html>
