<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <meta name="description" content="">
    <meta name="author" content="">
    <title>会员管理系统</title>
    <style type="text/css" >
    body {background: url("{{ asset('/home/images/back')}}/{{rand(1,10)}}.jpg") 50% 0 no-repeat;}
    h1{margin: 80px auto 50px auto;text-align: center;color: #fff;margin-left: -25px;font-size: 35px;font-weight: bold;text-shadow: 0px 1px 1px #555;}
    .logo{ width:120px;height:90px; margin:0 auto;border-radius: 5px;}
    .login-panel {margin-top: 10%;}
    </style>

<script type="text/javascript">
    if(window.parent != window){
        window.top.location.href = window.location.href;
    }
</script>
</head>

<body>
<h1>欢迎来到 {{$l_web['web_name']}} 会员管理系统</h1>
<div style="width:100%;">
    <div class="logo">
        <img src="{{ asset('/home/images/logo.jpg') }}" class="logo" />
    </div>

</div>
<div class="container">

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">登录管理系统</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="{{url('home/doLogin')}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="用户名" name="name" type="text" value="{{ old('name') }}" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="密码" name="password" type="password" value="{{ old('password') }}">
                            </div>
                            <!-- <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">记住我
                                </label>
                            </div> -->
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="submit" class="btn btn-lg btn-success btn-block" value="登录" />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="error_msg_modal" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog modal-sm" role="alert">
        <div class="modal-content alert-danger">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"><i class="fa fa-warning"></i>提示</h3>
            </div>
            <div class="modal-body" id="error_msg_body">
                <h4 class="error_msg"></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">确认</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@include('home.includes.loadjs')

@include('home.includes.footer')

</body>
</html>
