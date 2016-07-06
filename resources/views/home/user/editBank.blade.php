<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <link href="{{ asset('/plus/bootstrap/dist/css/bootstrapValidator.min.css') }}" rel="stylesheet" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>绑定结款账号  - {{$l_web['web_name']}}</title>

</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->

        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">结款账号</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="col-lg-12 row">
                <form id="defaultForms" method="post" class="form-horizontal" action="{{url('home/userDoEditBank')}}" >
                    <div class="form-group">
                        <label class="col-lg-3 control-label">账户类型</label>
                        <div class="col-lg-5">
                            <select name="card_type" class="form-control card_type">
                                <option value="3" @if(($user->exists && $user->card_type == 3) || old('card_type') == 3) selected @endif>微信号</option>
                                <option value="1" @if(($user->exists && $user->card_type == 1) || old('card_type') == 1) selected @endif>支付宝</option>
                                <option value="2" @if(($user->exists && $user->card_type == 2) || old('card_type') == 2) selected @endif>银行卡</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group bank" @if(($user->exists && $user->card_type != 2) || (old('card_type') && old('card_type') != 2))style="display:none"@endif>
                        <label class="col-lg-3 control-label">开户银行</label>
                        <div class="col-lg-5">
                            <select name="card_bank" class="form-control card_bank">
                                @foreach($bank as $key => $value)
                                <option value="{{$value->id}}" @if(($user->exists && $user->card_bank == $value->id) || old('card_bank') == $value->id) selected @endif>{{$value->bank_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group bank alipay" @if(($user->exists && $user->card_type == 3) || old('card_type') == 3)style="display:none"@endif>
                        <label class="col-lg-3 control-label">账号名称</label>
                        <div class="col-lg-5">
                            {{$user->card_name}}--------{{ old('card_name') }}
                            <input type="text" class="form-control" name="card_name" value="@if($user->exists){{{$user->card_name}}}@else{{{ old('card_name') }}}@endif" />
                            根据上面选择的账户类型，填写相应的账号名
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">结款账户</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="card_no" value="@if($user->exists){{{$user->card_no}}}@else{{{ old('card_no') }}}@endif" />
                            根据上面选择的账户类型，填写对应的账号
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-info" id="subBtn">修改</button>
                            <button type="button" class="btn btn-info" id="resetBtn">取消</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    @include('home.includes.loadjs')
    <script src="{{ asset('/plus/bootstrap/dist/js/bootstrapValidator.min.js') }}"></script>

    <script>

    @if($errors->any())
        l.error("{{$errors->first()}}");
    @endif

    $(".card_type").on('change',function(){
        var val = $(this).val()
        if(val == 2){   //银行卡
            $('.bank').show();
        }else if(val == 1){ //支付宝
            $('.bank').hide();
            $('.alipay').show();
        }else if(val == 3){     //微信
            $('.bank').hide();
        }
    })


    </script>

</body>

</html>
