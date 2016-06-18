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
            <div class="col-lg-12 row">
                <form id="defaultForms" method="post" class="form-horizontal" action="{{url('home/userDoSelfUp')}}" >

                    <div class="form-group">
                        <label class="col-lg-3 control-label">确认新密码</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="confirm_password" value=""/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-info" id="subBtn">确认升级</button>
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
