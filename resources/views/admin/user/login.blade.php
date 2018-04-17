<!DOCTYPE html>
<html>
  <head>
    <title>Premier League</title>
    <base href="{{asset('')}}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS-->
    <link rel="shortcut icon" href='{!!asset("files/premier.png")!!}' />
    <link rel="stylesheet" type="text/css" href='{!!asset("templates/admin/css/main.css")!!}'>
    
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
        <h1 style="text-align: center;">Premier League</h1>
        <h4 style="width: 300px; color: red;font-size: 18px;
    font-family: arial;">
        
          @if(Session::has("msg"))
          {{Session::get("msg")}}
         @endif
          
        </h4>
      </div>
      <div class="login-box">
        <form class="login-form" action="{{route('admin.user.postlogin')}}"  method="post">
          {{csrf_field()}}
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
          <div class="form-group">
            <label class="control-label">USERNAME</label>
            <input class="form-control" type="text" placeholder="username" name="username" autofocus required>
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input class="form-control" type="password" name="password" required placeholder="Password">
          </div>
          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">
               
              </div>
              <p class="semibold-text mb-0"><a data-toggle="flip">Forgot Password ?</a></p>
            </div>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block">SIGN IN<i class="fa fa-sign-in fa-lg"></i></button>
          </div>
        </form>
        <form class="forget-form" action="{{route('admin.user.postpass')}}" method="post">
        {{csrf_field()}}
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
          <div class="form-group">
           <input class="form-control" type="hidden"  name='tieude' value='Mã xác nhận tài khoản'>
            <label class="control-label">EMAIL</label>

            <input class="form-control" type="email" placeholder="Email" name='mail' required>
          </div>
           @if ($errors->has('mail'))
              <span style="color: red;">{{ array_first($errors->get('mail')) }}</span>
            @endif
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type='submit'>Check<i class="fa fa-unlock fa-lg"></i></button>
          </div>
          <div class="form-group mt-20">
            <p class="semibold-text mb-0"><a data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
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