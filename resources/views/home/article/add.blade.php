<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <meta name="description" content="">
    <meta name="author" content="">

    <title>资讯管理 - {{$l_web['web_name']}}</title>

</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->

        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">{{$title}}资讯</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="col-lg-12 row">
                <form id="defaultForms" method="post" class="form-horizontal" action="{{url('home/articleDoAddEdit')}}" >
                    <input type="hidden" class="form-control" name="id" value="@if($article['exists']){{{$article['id']}}}@else{{{ old('id') }}}@endif"/>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">标题</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="title" value="@if($article['exists']){{{$article['title']}}}@else{{{ old('title') }}}@endif"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">摘要</label>
                        <div class="col-lg-5">
                            <textarea class="form-control" name="description">@if($article['exists']){{{$article['description']}}}@else{{{ old('description') }}}@endif</textarea>
                            摘要信息，100字之内
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">内容</label>
                        <div class="col-lg-5">
                            <textarea class="form-control" name="content" rows="8">@if($article['exists']){{{$article['content']}}}@else{{{ old('content') }}}@endif</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">是否置顶</label>
                        <div class="col-lg-5">
                            <input type="checkbox" name="is_top" value="1" @if(($article['exists'] && $article['is_top']) || old('is_top')) checked @endif />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-info" id="subBtn">保存</button>
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
    <script type="text/javascript">


    </script>
    @include('home.includes.footer')
</body>

</html>
