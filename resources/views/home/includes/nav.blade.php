        <style>
        .navbar-header{height:80px;}
        .navbar-top-links{height:80px;}

        /*@media (min-width: 768px){
            .sidebar {margin-top:81px;}
        }*/
        .navbar-top-links .dropdown-messages {width:auto;}
        .navbar-brand{height:80px;}
        .web_name{line-height: 50px;font-size:28px;}
        #title i {font-size: 25px;}
        .modal-title i {margin-right: 5px;}

        .modal-header{border:none}
        .modal-footer{border:none}
        .loading{width:175px; margin: 10px auto; padding:5px 10px;color:#FFFFFF;display:none;}
        .panel .panel-heading a{color:#FFFFFF;}
        .panel-primary{background-color: #337ab7;}
        .loading_img{width:20px;height:20px;margin-right: 5px;}
        </style>
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;position:relative">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{url('home/index')}}"><img src="{{ asset('/home/images/logo.jpg') }}" width="80" height="50" /></a>
                <div class="navbar-brand web_name">{{$l_web['web_name']}}</div>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
                <!--<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>smallnews</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>欢迎来到会员管理系统</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>查看所有信息</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>-->
                    <!-- /.dropdown-messages -->
                <!--</li>-->
                <!-- /.dropdown -->
                <!--<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>任务 1</strong>
                                        <span class="pull-right text-muted">40% 完成</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% 完成 (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>查看所有任务</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                <!--</li>-->
                <!-- /.dropdown -->
                <!--<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> 新提醒
                                    <span class="pull-right text-muted small">4 分钟以前</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>查看所有提醒</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                <!--</li>-->
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> {{$l_user['name']}}</a>
                        </li>
                        <li><a href="{{url('home/userEdit')}}"><i class="fa fa-edit fa-fw"></i> 完善资料</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{url('home/logout')}}"><i class="fa fa-sign-out fa-fw"></i> 退出</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <!-- 左侧菜单 -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!-- 搜索框<li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        <!-- </li> -->
                        <li>
                            <a href="{{url('home/index')}}"><i class="fa fa-home fa-fw"></i> 首页<span class="fa arrow"></span></a>
                        </li>
                        <li>
                            <a><i class="fa fa-user fa-fw"></i> 会员管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('home/userList')}}">会员列表</a>
                                </li>
                                <li>
                                    <a href="{{url('home/userAdd')}}">快速添加会员</a>
                                </li>
                                <li>
                                    <a href="{{url('home/userEdit')}}">完善个人资料</a>
                                </li>
                                <li>
                                    <a href="{{url('home/userEditBank')}}">结款账号</a>
                                </li>
                                <li>
                                    <a href="{{url('home/userEditPass')}}">修改密码</a>
                                </li>
                                <li>
                                    <a href="{{url('home/userSelfUp')}}">自助升级</a>
                                </li>
                                <li>
                                    <a href="{{url('home/userNetwork')}}">网络图管理</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a><i class="fa fa-credit-card fa-fw"></i> 提现管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('home/cashList')}}">提现列表</a>
                                </li>
                                <li>
                                    <a href="{{url('home/cashAdd')}}">申请提现</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a><i class="fa fa-money fa-fw"></i> 钱包<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('home/myWallet')}}">我的钱包</a>
                                </li>
                                <li>
                                    <a href="{{url('home/walletLog')}}">钱包记录</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{url('home/articleList')}}"><i class="fa fa-bell fa-fw"></i> 站内资讯<span class="fa arrow"></span></a>
                        </li>

                        @if($l_user->super_man)
                        <li>
                            <a><i class="fa fa-dashboard fa-fw"></i> 系统管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('home/setting')}}">系统设置</a>
                                </li>
                                <li>
                                    <a href="{{url('home/adminUserList')}}">用户列表</a>
                                </li>
                                <li>
                                    <a href="{{url('home/adminUserAdd')}}">快速添加用户</a>
                                </li>
                                <li>
                                    <a href="{{url('home/walletUp')}}">用户钱包充值</a>
                                </li>
                                <li>
                                    <a href="{{url('home/adminCashList')}}">提现申请</a>
                                </li>
                                <li>
                                    <a href="{{url('home/adminUserNetwork')}}">网络图管理</a>
                                </li>
                                <li>
                                    <a href="{{url('home/adminWalletList')}}">钱包列表</a>
                                </li>
                                <li>
                                    <a href="{{url('home/adminRechargeLogList')}}">充值记录</a>
                                </li>
                                <li>
                                    <a><i class="fa fa-list-alt fa-fw"></i> 资讯管理 <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="{{url('home/adminArticleList')}}">资讯列表</a>
                                        </li>
                                        <li>
                                            <a href="{{url('home/articleAdd')}}">资讯添加</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
            <div class="panel panel-primary loading"><img src="{{ asset('/home/images/loading.gif') }}" class="loading_img" />正在处理，请稍候...</div>
        </nav>

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

        <div class="modal fade" id="success_msg_modal" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog modal-sm" role="alert">
                <div class="modal-content alert-success">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title"><i class="fa fa-check-circle"></i>提示</h3>
                    </div>
                    <div class="modal-body" id="success_msg_body">
                        <h4 class="success_msg"></h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">确认</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
