<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <link href="{{ asset('/plus/bootstrap/dist/css/bootstrapValidator.min.css') }}" rel="stylesheet" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>系统设置 - {{$l_web['web_name']}}</title>

</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->

        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">系统设置</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="col-lg-12 row">
                <form id="defaultForms" method="post" class="form-horizontal" action="{{url('home/settingDoEdit')}}" >
                    <div class="form-group">
                        <label class="col-lg-3 control-label">网站名称</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="web_name" value="@if($setting->exists){{{$setting->web_name}}}@else{{{ old('web_name') }}}@endif"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">激活用户</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="active_money" value="@if($setting->exists){{{$setting->active_money}}}@else{{{ old('active_money') }}}@endif"/>
                            激活用户需要消耗的亿联币
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-info" id="subBtn">设置</button>
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

    </script>

</body>

</html>
