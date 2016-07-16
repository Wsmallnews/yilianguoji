<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <meta name="description" content="">
    <meta name="author" content="">

    <title>充值记录 - {{$l_web['web_name']}}</title>

</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->

        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">充值记录</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            充值记录列表
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" id="list_div">
                            <div id="search_div">
                                <!-- <form class="form-inline" id="table_div_search">
                                    <div class="form-group">
                                        <label>用户名</label>
                                        <input type="text" class="form-control" name="keyword" placeholder="关键字">
                                    </div>
                                    <button type="button" class="btn btn-primary" id="search">搜索</button>
                                </form> -->
                            </div>
                            <div id="table_div">
                                @include('home.rechargeLog.li')
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
    <script type="text/javascript" >

    list.init_page();

    </script>

    @include('home.includes.footer')

</body>

</html>
