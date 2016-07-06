<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <meta name="description" content="">
    <meta name="author" content="">

    <title>用户钱包充值 - {{$l_web['web_name']}}</title>

</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->

        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">用户钱包充值</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="col-lg-12 row">
                <form id="walletForms" method="post" class="form-horizontal" action="{{url('home/doWalletUp')}}">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">搜索用户</label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" name="keyword" placeholder="关键字">
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-primary" id="search_url">搜索</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">充值用户</label>
                        <div class="col-lg-5">
                            <select class="form-control" id="user_id" name="user_id">
                                <option value="0">请选择用户...</option>
                                @include('home.wallet.option')
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">充值金额</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="money" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-info" id="subBtn">充值</button>
                            <button type="button" class="btn btn-info" id="resetBtn">取消</button>
                        </div>
                    </div>
                <form>
                <!-- /.col-lg-12 -->
            </div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    @include('home.includes.loadjs')
    <script type="text/javascript" >

    list.init('#user_id');

    $("#search_url").on('click',function(){
        var keyword = $('input[name=keyword]').val();
        list.search_list({keyword:keyword});
    })
    </script>

    @include('home.includes.footer')

</body>

</html>
