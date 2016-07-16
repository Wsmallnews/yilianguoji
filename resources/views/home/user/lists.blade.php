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

    <!-- 修改密码 -->
    <div class="modal fade" id="resetPassModal" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="title_reset_pass"></h4>
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
                    <button type="button" class="btn btn-primary" id="confirm_reset_pass">确认</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- 激活用户 -->
    <div class="modal fade" id="activeModal" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="title_active">确定要激活该用户吗？激活将消耗{{$l_web->active_money}} 亿联币！</h4>
                </div>
                <div class="modal-body">
                    <form id="form_active">
                        <input type="hidden" name="id" value="0" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="confirm_active">确认</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <!-- 冻结用户 -->
    <div class="modal fade" id="freezeModal" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="title_freeze"></h4>
                </div>
                <div class="modal-body">
                    <form id="form_freeze">
                        <input type="hidden" name="id" value="0" />
                        <input type="hidden" name="type" value="close" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="confirm_freeze">确认</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    @include('home.includes.loadjs')
    <script type="text/javascript" >

    list.init_page();

    //激活用户
    l.confirm({
        modal : "#activeModal",
        big_id : "#table_div",
        little_id : ".active_btn",
        confirm_id : "#confirm_active"
    },function(obj){
        var id = $(obj).parents('tr').attr('user_id');
        var user_name = $(obj).parents('tr').find('.user_name').html();

        $('#form_active').find('input[name=id]').val(id);
    },function(){
        var data = l.parseFormJson("#form_active");

        l.hideModel("#activeModal");

        l.ajax({
            url:"{{URL::to('home/userActive')}}",
            data:data,
            type:'get',
            success:function(r){
                if(r.error == 0){
                    l.success(r.info);
                    list.reload();
                    return;
                }
                l.error(r.info);
                return;
            }
        });
        return false;
    });

    @if($l_user->super_man && Route::currentRouteName() == 'userListAdmin')
    //冻结，解冻，删除
    l.confirm({
        modal : "#freezeModal",
        big_id : "#table_div",
        little_id : ".freeze_btn",
        confirm_id : "#confirm_freeze"
    },function(obj){
        var id = $(obj).parents('tr').attr('user_id');
        var user_name = $(obj).parents('tr').find('.user_name').html();
        var type = $(obj).attr('btn_type');
        if(type == 'open'){
            var msg = "确定要解冻“"+ user_name +"”吗？";
        }else if(type == 'del'){
            var msg = "确定要删除“"+ user_name +"”吗？删除之后不可恢复";
        }else {
            var msg = "确定要冻结“"+ user_name +"”吗？";
        }
        $('#form_freeze').find('input[name=type]').val(type);
        $('#form_freeze').find('input[name=id]').val(id);
        $('#title_freeze').html(msg);
    },function(){
        var data = l.parseFormJson("#form_freeze");

        l.hideModel("#freezeModal");

        l.ajax({
            url:"{{URL::to('home/userFreeze')}}",
            data:data,
            type:'get',
            success:function(r){
                if(r.error == 0){
                    l.success(r.info);
                    list.reload();
                    return;
                }
                l.error(r.info);
                return;
            }
        });
        return false;
    });

    //重置密码
    l.confirm({
        modal : "#resetPassModal",
        big_id : "#table_div",
        little_id : ".reset_user_btn",
        confirm_id : "#confirm_reset_pass"
    },function(obj){
        var id = $(obj).parents('tr').attr('user_id');
        var user_name = $(obj).parents('tr').find('.user_name').html();

        var msg = '正在为“'+user_name+'”重置密码';

        $('#title_reset_pass').html(msg);
        $('#reset_form').find('input[name=id]').val(id);

    },function(){
        var data = l.parseFormJson("#reset_form");

        if(data.password == ''){
            $("#password").addClass('has-error');
            return false;
        }else if(data.password != data.conf_password){
            $("#conf_password").addClass('has-error');
            return false;
        }

        l.hideModel("#resetPassModal");

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

    });
    @endif

    </script>

    @include('home.includes.footer')

</body>

</html>
