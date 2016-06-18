        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{url('home/index')}}">{{$l_web['web_name']}}</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
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
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
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
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
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
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> 我的资料</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> 设置</a>
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
                            <a><i class="fa fa-dashboard fa-fw"></i> 会员管理<span class="fa arrow"></a>
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
                                    <a href="{{url('home/userEditPass')}}">修改密码</a>
                                </li>
                                <li>
                                    <a href="{{url('home/userSelfUp')}}">自助升级</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a><i class="fa fa-dashboard fa-fw"></i> 提现管理<span class="fa arrow"></a>
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
                            <a><i class="fa fa-dashboard fa-fw"></i> 钱包<span class="fa arrow"></a>
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
                            <a><i class="fa fa-dashboard fa-fw"></i> 系统设置<span class="fa arrow"></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('home/setting')}}">系统设置</a>
                                </li>
                            </ul>
                        </li>

                        <!-- <li>
                            <a><i class="fa fa-dashboard fa-fw"></i> 支出队列<span class="fa arrow"></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('home/outList')}}">排队列表</a>
                                </li>
                                <li>
                                    <a href="{{url('home/outAdd')}}">添加排队</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> 第二个菜单<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="flot.html">第二级一</a>
                                </li>
                                <li>
                                    <a href="morris.html"><span class="fa arrow"></span>第二级二</a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#"></a>
                                        </li>
                                        <li>
                                            <a href="#">第三级一</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul> -->
                            <!-- /.nav-second-level -->
                        <!-- </li> -->
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
