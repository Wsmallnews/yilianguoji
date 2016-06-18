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
                    <div class="form-group">
                        <label class="col-lg-3 control-label">用户名</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" onblur="validate('no')"/>
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

    @if($errors->any())
        l.error("{{$errors->first()}}");
    @endif

    function validate(type){
        var name = $("#name").val();
        if(name == ''){
            l.error('用户名不能为空');
            $("#name").css({'border': '1px solid #FF0000'});
            return false;
        }

        l.ajax({
            url:"{{URL::to('home/userNameUnique')}}",
            data:{'name':name},
            type:'get',
            success:function(r){
                if(r.error == 0){
                    $("#name").css({'border': '1px solid #ccc'});
                    if(type == 'yes'){
                        $("#defaultForms").submit();
                    }
                    return true;
                }
                $("#name").css({'border': '1px solid #FF0000'});
                l.error(r.info);
                return false;
            }
        });
    }



    </script>

</body>

</html>
