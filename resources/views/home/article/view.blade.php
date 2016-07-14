<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <meta name="description" content="">
    <meta name="author" content="">

    <title>资讯内容 - {{$l_web['web_name']}}</title>
    <style>
    .article_content{padding:10px;}
    .title{text-align: center;font-weight: bold;}
    .updated_at{text-align:right;color:#cccccc;}
    .desc{border:1px dashed #cccccc;padding:10px;margin:20px 50px;border-radius: 5px;}
    .content {text-indent:2em;}
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->

        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">资讯内容</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="col-lg-12 row article_content">
                <h3 class="title">{{$article->title}}</h3>
                <p class="updated_at">{{$article->updated_at}}</p>
                <div class="desc">{{$article->description}}</div>
                <div class="content">{{$article->content}}</div>
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
