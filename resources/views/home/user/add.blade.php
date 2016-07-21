<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <link href="{{ asset('/plus/bootstrap/dist/css/bootstrapValidator.min.css') }}" rel="stylesheet" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>快速添加用户  - {{$l_web['web_name']}}</title>

</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->

        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">快速添加会员</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="col-lg-12 row">
                <form id="defaultForms" method="post" class="form-horizontal" action="{{url('home/userDoAdd')}}" >
                    @if($l_user->super_man && Route::currentRouteName() == 'userAddAdmin')
                    <div class="form-group">
                        <label class="col-lg-3 control-label">搜索推荐人</label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" name="keyword_direct" placeholder="关键字">
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-primary" id="search_direct">搜索</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">推荐人</label>
                        <div class="col-lg-5">
                            <select class="form-control" id="direct_id" name="direct_id">
                                <option value="0">请选择用户...</option>
                                @include('home.wallet.option')
                            </select>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <label class="col-lg-3 control-label">搜索接点人</label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" name="keyword_parent" placeholder="关键字">
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-primary" id="search_parent">搜索</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">接点人</label>
                        <div class="col-lg-5">
                            <select class="form-control" id="parent_id" name="parent_id">
                                <option value="0">请选择用户...</option>
                                @include('home.wallet.option')
                            </select>
                        </div>
                    </div>


                    <div class="form-group" id="name">
                        <label class="col-lg-3 control-label">用户名</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" onblur="validate('no')"/>
                            将作为登录账号使用，添加后不可修改
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label class="col-lg-3 control-label">昵称</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="nick_name" value="{{ old('nick_name') }}" />
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label class="col-lg-3 control-label">密码</label>
                        <div class="col-lg-5">
                            <input type="password" class="form-control" name="password" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">确认密码</label>
                        <div class="col-lg-5">
                            <input type="password" class="form-control" name="confirmPassword" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="button" class="btn btn-info" id="subBtn" onclick="validate('yes')">注册</button>
                            <button type="button" class="btn btn-info" id="resetBtn">取消</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    @include('home.includes.loadjs')
    <script src="{{ asset('/plus/bootstrap/dist/js/bootstrapValidator.min.js') }}"></script>

    <script>

    $("#search_direct").on('click',function(){
        var keyword = $('input[name=keyword_direct]').val();
        list.search_list({keyword:keyword},function(r){
            if(r.error == 0){
    			$('#direct_id').html(r.data.html);
    		}else{
    			l.error(r.info);
    		}
        });
    })

    $("#search_parent").on('click',function(){
        var keyword = $('input[name=keyword_parent]').val();
        list.search_list({keyword:keyword},function(r){
            if(r.error == 0){
    			$('#parent_id').html(r.data.html);
    		}else{
    			l.error(r.info);
    		}
        });
    })

    function validate(type){
        var name = $("input[name=name]").val();
        if(name == ''){
            l.error('用户名不能为空');
            $("#name").addClass('has-error');
            return false;
        }

        l.ajax({
            url:"{{URL::to('home/userNameUnique')}}",
            data:{'name':name},
            type:'get',
            success:function(r){
                if(r.error == 0){
                    $("#name").removeClass('has-error');
                    if(type == 'yes'){
                        $("#defaultForms").submit();
                    }
                    return true;
                }
                $("#name").addClass('has-error');
                l.error(r.info);
                return false;
            }
        });
    }
    </script>

    @include('home.includes.footer')
</body>

</html>
