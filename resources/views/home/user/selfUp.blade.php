<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <link href="{{ asset('/plus/bootstrap/dist/css/bootstrapValidator.min.css') }}" rel="stylesheet" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>自助升级  - {{$l_web['web_name']}}</title>

</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->

        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">自助升级</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-diamond fa-5x"></i>
                                </div>
                                <div class="col-xs-6">
                                    <!-- 升级到下一级需要多少亿联币 -->
                                </div>
                                <div class="col-xs-3 text-right">
                                    <div class="huge">{{$user->rank}}</div>
                                    <div>当前等级</div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0)">
                            <div class="panel-footer" id="auto_up">
                                <span class="pull-left">自助升级</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 自助升级等级说明 -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            自助升级等级说明，及需要的亿联币
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" id="list_div">
                            <div id="table_div">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>编号</th>
                                            <th>所需亿联币</th>
                                            <th>等级</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($auto_up as $list)
                                        <tr class="gradeC" user_id="{{$list->id}}">
                                            <td>{{$list->id}}</td>
                                            <td>升级到当前级别需要 <span style="color:#ff8800">{{$list->need_money}}</span> 亿联币</td>
                                            <td>{{$list->rank}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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

    <script>

    @if($errors->any())
        l.error("{{$errors->first()}}");
    @endif

    $("#auto_up").on('click',function(){
        if(l.confirm('确定要升级吗？')){
            l.ajax({
                url:"{{URL::to('home/userDoSelfUp')}}",
                type:'get',
                success:function(r){
                    if(r.error == 0){
                        l.success('恭喜您，升级成功！');
                        l.reload();
                        return true;
                    }
                    l.error(r.info);
                    return false;
                }
            });
        }
    })


    </script>

</body>

</html>
