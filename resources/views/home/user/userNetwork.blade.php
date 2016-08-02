<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <link href="{{ asset('/plus/bootstrap/dist/css/bootstrapValidator.min.css') }}" rel="stylesheet" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>网络管理  - {{$l_web['web_name']}}</title>
    <style>
        .middle_div{margin: 0 auto;}
        .middle{margin: 0 auto;}
        .middle_son{margin: 0 auto;overflow:hidden;}
        .user_logo{width:60px;height:60px;}
        .user_name{padding:5px;}
        .panel-primary.user_info{width:240px; z-index:100;position:fixed;background-color: #FFFFFF;}
        #table_div .row{text-align: center;}
        .col-lg-4{padding:0px;}
        .user_field{color:#337ab7;}
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->

        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">网络图</h1>
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
                            @if($l_user->super_man && Route::currentRouteName() == 'adminNetwork')
                            <div id="search_div">
                                <form class="form-inline" id="table_div_search">
                                    <div class="form-group">
                                        <label>用户名</label>
                                        <input type="text" class="form-control" name="keyword" value="{{$keyword}}" placeholder="关键字">
                                    </div>
                                    <button type="button" class="btn btn-primary" id="search">搜索</button>
                                </form>
                            </div>
                            @endif
                            <div id="table_div">
                                @if($user)
                                <div class="row">
                                    <div class="middle_div" info="{{json_encode($user)}}">
                                        <img src="{{ asset('/home/images')}}/{{$user->rank}}.png" class="user_logo" />
                                        <div class="user_name">
                                            {{$user->name}}
                                        </div>
                                    </div>
                                    <div class="middle">
                                        <img src="{{ asset('/home/images/network.png') }}" width="100%" height="50" />
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="middle_div" style="font-size:28px;">没有找到该用户</div>
                                </div>
                                @endif
                                <div class="row">
                                    @foreach($son_list as $list)
                                    <div class="col-lg-4 col-xs-4">
                                        <div class="middle_son">
                                            <div class="middle_div" info="{{json_encode($list)}}">
                                                <a href="@if($l_user->super_man){{URL::to('home/adminUserNetwork',array('id'=>$list['id']))}}@else javascript:void(0); @endif">
                                                    <img src="{{ asset('/home/images') }}/{{$list['rank']}}.png" class="user_logo" />
                                                </a>
                                                <div class="user_name">
                                                    {{$list['name']}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="middle">
                                            <img src="{{ asset('/home/images/network_child.png') }}" width="100%" height="50" />
                                        </div>
                                        <div class="row">
                                            @foreach($list['grandson'] as $li)
                                            <div class="col-lg-4 col-xs-4">
                                                <div class="middle_son">
                                                    <div class="middle_div" info="{{json_encode($li)}}">
                                                        <a href="@if($l_user->super_man){{URL::to('home/adminUserNetwork',array('id'=>$li['id']))}}@else javascript:void(0); @endif">
                                                            <img src="{{ asset('/home/images') }}/{{$li['rank']}}.png" class="user_logo" />
                                                        </a>
                                                        <div class="user_name">
                                                            {{$li['name']}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

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

    <div class="panel panel-primary user_info">
        <div class="panel-heading">
            <i class="fa fa-user fa-fw"></i>
            基本信息
        </div>
        <div class="panel-body">
            <p>用户名：<span class="user_field lead">{{$l_user->name}}</span></p>
            <p>等级：<span class="user_field rank">{{$l_user->rank}}</span></p>
            <p>邮箱：<span class="user_field email">{{$l_user->email}}</span></p>
            <p>手机号：<span class="user_field phone">{{$l_user->phone}}</span></p>
            <p>真实姓名：<span class="user_field real_name">{{$l_user->real_name}}</span></p>
            <p>身份证号：<span class="user_field cert_no">{{$l_user->cert_no}}</span></p>
        </div>
        <!-- /.panel-body -->
    </div>


    @include('home.includes.loadjs')

    <script>
    @if($l_user->super_man && Route::currentRouteName() == 'adminNetwork')
    $("#search").on('click',function(){
        var keyword = $("input[name=keyword]").val();
        l.location("{{URL::to('home/adminUserNetwork')}}/0/"+keyword);
    })
    @endif

    $(".user_logo").hover(function(){
        var point = getMousePos();

        var info = JSON.parse($(this).parents(".middle_div").attr('info'));

        $(".lead").html(info.name);
        $(".rank").html(info.rank);
        $(".email").html(info.email);
        $(".phone").html(info.phone);
        $(".real_name").html(info.real_name);
        $(".cert_no").html(info.cert_no);

        $(".user_info").css({'left':(parseFloat(point.x) - 120),'top':(parseFloat(point.y) + 30)});
        $(".user_info").show();
    },function(){
        $(".user_info").hide();
    })

    function getMousePos(event) {
        var e = event || window.event;
        return {'x':e.clientX,'y':e.clientY}
    }

    </script>
    @include('home.includes.footer')
</body>

</html>
