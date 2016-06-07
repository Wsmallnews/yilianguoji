<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <link href="{{ asset('/plus/bootstrap/dist/css/bootstrapValidator.min.css') }}" rel="stylesheet" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>添加用户  - {{$l_web['web_name']}}</title>

</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->

        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">添加会员</h1>
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
                            将作为登录账号使用
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label class="col-lg-3 control-label">昵称</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="nick_name" value="{{ old('nick_name') }}" />
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label class="col-lg-3 control-label">邮箱</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="email" value="{{ old('email') }}" />
                        </div>
                    </div>

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
                        <label class="col-lg-3 control-label">手机</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">性别</label>
                        <div class="col-lg-5">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="gender" id="inlineRadio1" value="male" @if(old('gender') == 'male') checked @endif /> 男
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="gender" id="inlineRadio2" value="female" @if(old('gender') == 'female') checked @endif /> 女
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="gender" id="inlineRadio3" value="other" @if(old('gender') == 'other' || old('gender') === null) checked @endif /> 其他
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">生日</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="birth" value="{{ old('birth') }}" /> 0000-00-00
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">真实姓名</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="real_name" value="{{ old('real_name') }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">身份证号</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="cert_no" value="{{ old('cert_no') }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">账户类型</label>
                        <div class="col-lg-5">
                            <select name="card_type" class="form-control">
                                <option value="1" @if(old('card_type') == 1 ) selected @endif>支付宝</option>
                                <option value="2" @if(old('card_type') == 2 ) selected @endif>银行卡</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">银行账户</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="card_no" value="{{ old('card_no') }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">现在激活</label>
                        <div class="col-lg-5">
                            <input type="checkbox" name="now_active" value="1" @if(old('now_active') == 1) checked @endif />
                            现在激活将直接扣除{{$l_web->active_money}} 亿联币
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
