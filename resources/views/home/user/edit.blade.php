<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <link href="{{ asset('/plus/bootstrap/dist/css/bootstrapValidator.min.css') }}" rel="stylesheet" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>完善个人资料  - {{$l_web['web_name']}}</title>

</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->

        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">完善个人资料</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="col-lg-12 row">
                <form id="defaultForms" method="post" class="form-horizontal" action="{{url('home/userDoEdit')}}" >
                    <div class="form-group">
                        <label class="col-lg-3 control-label">邮箱</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="email" value="@if($user->exists){{{$user->email}}}@else{{{ old('email') }}}@endif" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">手机</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" />
                            请填写正确的手机号
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">真实姓名</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="real_name" value="@if($user->exists){{{$user->real_name}}}@else{{{ old('real_name') }}}@endif" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">身份证号</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="cert_no" value="@if($user->exists){{{$user->cert_no}}}@else{{{ old('cert_no') }}}@endif" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">账户类型</label>
                        <div class="col-lg-5">
                            <select name="card_type" class="form-control">
                                <option value="3" @if(($user->exists && $user->card_type == 3) || old('card_type') == 3) selected @endif>微信号</option>
                                <option value="1" @if(($user->exists && $user->card_type == 1) || old('card_type') == 1) selected @endif>支付宝</option>
                                <option value="2" @if(($user->exists && $user->card_type == 2) || old('card_type') == 2) selected @endif>银行卡</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">结款账户</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="card_no" value="@if($user->exists){{{$user->cert_no}}}@else{{{ old('card_no') }}}@endif" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-info" id="subBtn">修改</button>
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

    </script>

</body>

</html>
