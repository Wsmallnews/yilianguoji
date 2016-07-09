<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <meta name="description" content="">
    <meta name="author" content="">

    <title>申请提现  - {{$l_web['web_name']}}</title>

</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->

        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">申请提现</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">


                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            提现说明
                        </div>
                        <div class="panel-body">
                            每笔提现处理成功将会收取<span style="color:#FF0000">{{$l_web->charge_scale * 100}}%</span>的手续费，最低收取<span style="color:#FF0000">{{$l_web->low_charge_money}}</span>元手续费
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>

                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            提现
                        </div>
                        <div class="panel-body">
                            <form id="defaultForms" method="post" class="form-horizontal" action="{{url('home/cashDoAdd')}}">

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">账号类型</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" disabled name="card_type_name" value="{{$user->card_type_name}}" />
                                    </div>
                                </div>

                                <div class="form-group" @if($user->card_type != 2)style="display:none"@endif>
                                    <label class="col-lg-3 control-label">开户银行</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" disabled name="card_bank" value="{{$user['bank']['bank_name']}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">账号名称</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" disabled name="card_name" value="{{$user->card_name}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">结款账号</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" disabled name="card_no" value="{{$user->card_no}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">提现金额</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="money" value="{{ old('money') }}" />
                                        <div class="col-lg-12">当前亿联币可用余额为{{$wallet->money}}元<span class="charge_span"></span></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-9 col-lg-offset-3">
                                        <button type="submit" class="btn btn-info" id="apply_cash">申请提现</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                        <!-- /.panel-body -->
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    @include('home.includes.loadjs')
    <script type="text/javascript">
    @if($l_web->is_charge)
    $('input[name=money]').on('keyup',function(){
        var money = parseFloat($(this).val());
        if(money > 0){
            var charge_scale = parseFloat('{{$l_web->charge_scale}}');
            var low_charge_money = parseFloat('{{$l_web->low_charge_money}}');
            var total_money = parseFloat('{{$wallet->money}}');

            var charge_money = parseFloat((money * charge_scale).toFixed(2));
            if(charge_money < low_charge_money){
                charge_money = low_charge_money
            }
            if((money + charge_money) <= total_money){
                $(".charge_span").html('，额外收取<b style="color:#FF0000">'+charge_money+'</b>元手续费');
                $("#apply_cash").attr('disabled',false);
            }else{
                $(".charge_span").html('，<b style="color:#FF0000">剩余余额不足以支付提现手续费，无法提现</b>');
                $("#apply_cash").attr('disabled',true);
            }
        }
    })
    @endif
    </script>
    @include('home.includes.footer')
</body>

</html>
