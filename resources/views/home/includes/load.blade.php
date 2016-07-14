    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="{{ asset('/plus/bootstrap/3.3.5/css/bootstrap.min.css') }}">

    <!-- MetisMenu CSS -->
    <link href="{{ asset('/plus/bootstrap/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="{{ asset('/plus/bootstrap/dist/css/timeline.css') }}" rel="stylesheet">

    <!-- 左边导航 -->
    <link href="{{ asset('/plus/bootstrap/dist/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{ asset('/plus/bootstrap/morrisjs/morris.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('/plus/font-awesome-4.4.0/css/font-awesome.min.css') }}" rel="stylesheet"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="{{ asset('/plus/bootstrap/html5shiv.min.js') }}"></script>
      <script src="{{ asset('/plus/bootstrap/respond.min.js') }}"></script>
    <![endif]-->

    <!-- 站内css 文件 -->
    <link href="{{ asset('/css/web_base.css') }}" rel="stylesheet"/>
