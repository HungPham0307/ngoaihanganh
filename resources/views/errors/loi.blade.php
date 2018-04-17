<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS-->
    <link rel="stylesheet" type="text/css" href="{{ $adminUrl }}/css/main.css">
    <title>Vali Admin</title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--if lt IE 9
    script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    script(src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    -->
  </head>
  <body>
    <div class="page-error">
      <h3><img src="{{ $imgUrl }}/errors/errors.jpg" style="width: 40px;height: 40px;"/> Bạn k có quyền truy cấp chức năng này </h3>
      
      <p><a href="{{route('admin.index.index')}}">Quay về trang chủ</a></p>
    </div>
  </body>
  <script src="{{ $adminUrl }}/js/jquery-2.1.4.min.js"></script>
  <script src="{{ $adminUrl }}/js/bootstrap.min.js"></script>
  <script src="{{ $adminUrl }}/js/plugins/pace.min.js"></script>
  <script src="{{ $adminUrl }}/js/main.js"></script>
</html>