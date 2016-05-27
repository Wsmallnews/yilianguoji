<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <meta name="description" content="">
    <meta name="author" content="">
<title>会员管理系统</title>
<link href="{{ asset('/home/css/login2.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css" >
.login_msg{border:2px solid #FB3304;width:auto;height:25px;background:#F5BCAE;position:absolute;left:48px;top:6px;border-radius:5px;color:#FFFFFF;padding:0 5px;line-height:25px;font-size:14px;}
body { background: #fff url({{ asset('/home/images/back')}}/{{rand(1,10)}}.jpg) 50% 0 no-repeat; }
.login{ background:none;padding:0;margin-top:50px;}
form label {color:#000000;}
.bg{position: absolute;width: 100%;height: 100%;background: #FFF; filter:alpha(opacity=80); -moz-opacity:0.8;  -khtml-opacity: 0.8;  opacity: 0.8; border: 1px solid #EEEEEE;border-radius: 8px;}
</style>

<script type="text/javascript">
    if(window.parent != window){
        window.top.location.href = window.location.href;
    }
</script>
</head>

<body>
<h1>欢迎来到 {{$l_web['web_name']}} 会员管理系统</h1>

<div class="login">
    <div class="bg"></div>
    <div class="header">
        <div class="switch" id="switch">
        	<a class="switch_btn_focus" id="switch_qlogin" href="javascript:void(0);" tabindex="7">快速登录</a>
        </div>
    </div>
    
    <div class="web_qr_login" id="web_qr_login" style="display: block; height: 235px;">    
        <!--登录-->

        @if($errors->any())
            <div class="login_msg" id="msg">提示：{{$errors->first()}}</div>
        @endif
        
        <div class="web_login" id="web_login">
            <div class="login-box">
				<div class="login_form">
					<form action="{{url('home/doLogin')}}" name="loginform" accept-charset="utf-8" id="login_form" class="loginForm" method="post">
		                <input type="hidden" name="_token" value="{{ csrf_token() }}">
		                <div class="uinArea" id="uinArea">
		                	<label class="input-tips" for="u">帐号：</label>
			                <div class="inputOuter" id="uArea">
			                    <input type="text" id="u" name="name" class="inputstyle" value="{{ old('name') }}" />
			                </div>
		                </div>
		                <div class="pwdArea" id="pwdArea">
		               		<label class="input-tips" for="p">密码：</label>
			               	<div class="inputOuter" id="pArea">
			                    <input type="password" id="p" name="password" class="inputstyle" value="{{ old('password') }}" />
			                </div>
		                </div>
		                <div style="padding-left:50px;margin-top:20px;"><input type="submit" value="登 录" style="width:150px;" class="button_blue"/></div>
	              	</form>
	           </div>
            </div>
       </div>
       <!--登录end-->
  	</div>
</div>
<div class="jianyi">{{$l_web['web_name']}} 官方网站</div>

<script type="text/javascript">

// 	$('#login_form').on('click','.button_blue',function(){
// 		zui.ajax({'url':"{{url('cms/login')}}",'data':"#login_form",
// 			success:function(result){
// 				alert(result);
// 			}
// 		});
// 	});
// });

</script>

</body>
</html>





