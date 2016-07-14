<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <meta name="description" content="">
    <meta name="author" content="">

    <title>欢迎来到 {{$l_web['web_name']}} - 会员管理系统</title>
    <style>
    .huge{font-size: 30px;}
    .panel .panel-heading a{color:#FFFFFF;}
    .panel-primary{background-color: #337ab7;}
    .panel-infos{background-color: #f0ad4e;}
    .chat-icon{padding: 10px;border-radius: 50%;background-color: #f0ad4e;color: #FFFFFF;}
    .chat .chat-body{color:#333333;}
    .chat a:hover{text-decoration:none;}
    #index_more{color:#333333;}
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->

        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">欢迎来到 {{$l_web['web_name']}} - 会员管理系统</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <a href="{{url('home/userEdit')}}">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <i class="fa fa-reorder fa-5x huge"></i>
                                    </div>
                                    <div class="col-xs-12 text-center">
                                        <div class="huge">资料管理</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <a href="{{url('home/userAdd')}}">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <i class="fa fa-plus-square fa-5x huge"></i>
                                    </div>
                                    <div class="col-xs-12 text-center">
                                        <div class="huge">快速注册</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-infos">
                        <div class="panel-heading">
                            <a href="{{url('home/userNetwork')}}">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <i class="fa fa-group fa-5x huge"></i>
                                    </div>
                                    <div class="col-xs-12 text-center">
                                        <div class="huge">网络管理</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red ">
                        <div class="panel-heading">
                            <a href="{{url('home/cashList')}}">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <i class="fa fa-credit-card fa-5x huge"></i>
                                    </div>
                                    <div class="col-xs-12 text-center">
                                        <div class="huge">提现列表</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-user fa-fw"></i>
                            基本信息
                        </div>
                        <div class="panel-body">
                            <p class="lead">用户名：{{$user->name}}</p>
                            <p>邮箱：{{$user->email}}</p>
                            <p>手机号：{{$user->phone}}</p>
                            <p>真实姓名：{{$user->real_name}}</p>
                            <p>身份证号：{{$user->cert_no}}</p>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <div class="col-lg-8">
                    <div class="chat-panel panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-comments fa-fw"></i>
                            站内资讯
                            <div class="btn-group pull-right">
                                <a href="{{URL::to('home/articleList')}}" id="index_more">
                                    <i class="fa fa-angle-double-right fa-fw"></i> 更多
                                </a>
                            </div>
                            <!-- <div class="btn-group pull-right">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu slidedown">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-refresh fa-fw"></i> Refresh
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-check-circle fa-fw"></i> Available
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-times fa-fw"></i> Busy
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-clock-o fa-fw"></i> Away
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-sign-out fa-fw"></i> Sign Out
                                        </a>
                                    </li>
                                </ul>
                            </div> -->
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="chat">
                                @foreach($article as $key => $list)
                                <li class="left clearfix" article_id="{{$list->id}}">
                                    <a href="{{url('home/articleView',array('id' => $list->id))}}">
                                        <span class="chat-icon pull-left">
                                            <i class="fa fa-hand-o-right fa-5x huge"></i>
                                        </span>

                                        <div class="chat-body clearfix">
                                            <div class="header">
                                                <strong class="primary-font">{{$list->title}}</strong>
                                                <small class="pull-right text-muted">
                                                    <i class="fa fa-clock-o fa-fw"></i> {{$list->updated_at}}
                                                </small>
                                            </div>
                                            <p>
                                                {{$list->description}}
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer" style="height:30px;">
                            <!-- <div class="input-group">
                                <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                                <span class="input-group-btn">
                                    <button class="btn btn-warning btn-sm" id="btn-chat">
                                        Send
                                    </button>
                                </span>
                            </div> -->
                        </div>
                        <!-- /.panel-footer -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    @include('home.includes.loadjs')

    @include('home.includes.footer')
</body>

</html>
