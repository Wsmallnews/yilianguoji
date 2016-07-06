<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <link href="{{ asset('/plus/bootstrap/dist/css/bootstrapValidator.min.css') }}" rel="stylesheet" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>网络管理  - {{$l_web['web_name']}}</title>
    <style>
        .middle_div{width: 200px;margin: 0 auto;}
        .middle{margin: 0 auto;}
        .middle_son{margin: 0 auto;overflow:hidden;}
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
                            <div id="table_div">
                                @if($user)
                                <div class="row">
                                    <div class="middle_div">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                {{$user->name}}
                                            </div>
                                            <div class="panel-body">
                                                <p>等级：<span>{{$user->rank}}</span></p>
                                            </div>
                                            <div class="panel-footer">
                                                <!-- <a href="javascript:void(0)">查看详细</a> -->
                                            </div>
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
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    {{$list['name']}}
                                                </div>
                                                <div class="panel-body">
                                                    <p>等级：<span>{{$list['rank']}}</span></p>
                                                </div>
                                                <div class="panel-footer">
                                                    <!-- <a href="javascript:void(0)">查看详细</a> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="middle">
                                            <img src="{{ asset('/home/images/network.png') }}" width="100%" height="50" />
                                        </div>
                                        <div class="row">
                                            @foreach($list['grandson'] as $li)
                                            <div class="col-lg-4 col-xs-4">
                                                <div class="middle_son">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading">
                                                            {{$li['name']}}
                                                        </div>
                                                        <div class="panel-body">
                                                            <p>等级：<span>{{$li['rank']}}</span></p>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <!-- <a href="javascript:void(0)">查看详细</a> -->
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

    @include('home.includes.loadjs')

    @include('home.includes.footer')
</body>

</html>
