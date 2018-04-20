<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS-->
    <link rel="stylesheet" type="text/css" href='{!!asset("templates/admin/css/main.css")!!}'>
    <title>Vali Admin</title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--if lt IE 9
    script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    script(src='https://oss.maxcdn.com/libs/respond.{{$adminUrl}}/js/1.4.2/respond.min.js')
    -->
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>About me</h1>
        <h4 style="margin-left: 37%; color: red;font-size: 18px;
    font-family: arial;">

          @if(Session::has("msg"))
          {{Session::get("msg")}}
         @endif
        </h4>
      </div>
      <div class="login-box">
        <form class="login-form" action="{{route('admin.user.postConfirm',$objUser->id)}} "  method="post">
          {{csrf_field()}}
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Enter infomation</h3>

          <div class="form-group">
            <label class="control-label">Code</label>
            <input class="form-control" type="number" name="xacnhan" required placeholder="Mã số">
          </div>
           @if ($errors->has('xacnhan'))
               <span style="color: red;">{{ array_first($errors->get('xacnhan')) }}</span>
          @endif
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block">Check<i class="fa fa-sign-in fa-lg"></i></button>
          </div>
        </form>

      </div>
    </section>
  </body>
  <script src='{!!asset("templates/admin/js/jquery-2.1.4.min.js")!!}'></script>
  <script src='{!!asset("templates/admin/js/bootstrap.min.js")!!}'</script>
  <script src='{!!asset("templates/admin/js/plugins/pace.min.js")!!}'></script>
  <script src='{!!asset("templates/admin/js/main.js")!!}'></script>
</html>
