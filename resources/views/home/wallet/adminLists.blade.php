<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <meta name="description" content="">
    <meta name="author" content="">

    <title>钱包列表 - {{$l_web['web_name']}}</title>
    <style>
        .modal-header{border:none}
        .modal-footer{border:none}
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->

        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">钱包列表</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            钱包列表
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" id="list_div">
                            <div id="search_div">
                                <form class="form-inline" id="table_div_search">
                                    <div class="form-group">
                                        <label>用户名</label>
                                        <input type="text" class="form-control" name="keyword" placeholder="关键字">
                                    </div>
                                    <button type="button" class="btn btn-primary" id="search">搜索</button>
                                </form>
                            </div>
                            <div id="table_div">
                                @include('home.wallet.li')
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

    <div class="modal fade" id="myModal" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal_title">给“<span></span>”进行充值</h4>
                </div>
                <div class="modal-body">
                    <form id="wallet_form">

                        <div class="form-group" id="money">
                            <label class="control-label" for="">充值金额</label>
                            <input name="money" class="form-control" type="number" />
                        </div>

                        <input type="hidden" name="user_id" value="0" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="confirm">确认</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    @include('home.includes.loadjs')
    <script type="text/javascript" >
    list.init();

    $('#myModal').modal({
        show:false
    });

    l.prompt({
        modal : "#myModal",
        big_id : "#table_div",
        little_id : ".oper_btn",
        confirm_id : "#confirm"
    },function(obj){
        var id = $(obj).parents('tr').attr('wallet_id');
        var user_name = $(obj).parents('tr').find('.user_name').html();

        $('#wallet_form').find('input[name=user_id]').val(id);
        $("#modal_title").find('span').html(user_name);
        $('#myModal').modal('show');
    },function(){
        var data = l.parseFormJson("#wallet_form");

        if(data.money == '' || parseFloat(data.money) == 0){
            $("#money").addClass('has-error');
            return false;
        }

        l.hideModel("#myModal");

        l.ajax({
            url:"{{URL::to('home/doWalletUp')}}",
            data:data,
            type:'post',
            success:function(r){
                if(r.error == 0){
                    l.success(r.info);
                    list.reload();
                    return;
                }
                l.error(r.info);
                return;
            }
        });

        return false;
    });

    // $("#table_div").on('click',".oper_btn",function(){
    //     var id = $(this).parents('tr').attr('wallet_id');
    //
    //     $('#wallet_form').find('input[name=id]').val(id);
    //     $('#myModal').modal('show');
    // });
    //
    // $("#confirm").on('click',function(){
    //
    // })

    </script>
    @include('home.includes.footer')
</body>

</html>
