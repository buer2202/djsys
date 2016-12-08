<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>优家云微端</title>

    <script src="//cdn.bootcss.com/jquery/2.2.1/jquery.min.js"></script>
    <link href="//cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="//cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <style>
        body {
            font-family: '微软雅黑';
        }
    </style>

    @yield('head')
</head>
<body>
    <img src="/images/header.jpg" width="100%" />
    @yield('content')
</body>
</html>
