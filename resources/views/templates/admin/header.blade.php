
<!DOCTYPE html>
<html>
  <head>
	<title>Premier League</title>
  <base href="asset('')">
    <meta charset="utf-8">
    <link rel="shortcut icon" href='{!!asset("files/premier.png")!!}' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('templates/admin/css/main.css')}}">
	<link href="/files/vinacenter.png" rel="shortcut icon">
	 <!-- Javascripts-->
    <script src='{!!asset("templates/admin/js/jquery-2.1.4.min.js")!!}'></script>
    <script src='{!!asset("templates/admin/js/jquery.validate.min.js")!!}'></script>
    <script src='{!!asset("templates/admin/js/bootstrap.min.js")!!}'></script>
    <script src='{!!asset("templates/admin/js/plugins/pace.min.js")!!}'></script>
    <script src='{!!asset("templates/admin/js/main.js")!!}'></script>
    <script src='{!!asset("templates/admin/js/plugins/jquery.dataTables.min.js")!!}'></script>
    <script src='{!!asset("templates/admin/js/plugins/dataTables.bootstrap.min.js")!!}'></script>
    <script src='{!!asset("templates/admin/ckeditor/ckeditor.js")!!}'></script>
  </head>
  <body class="sidebar-mini fixed">
    <div class="wrapper">
      <!-- Navbar-->
      <header class="main-header hidden-print"><a class="logo" href="#">Admin</a>
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button--><a class="sidebar-toggle" href="#" data-toggle="offcanvas"></a>
          <!-- Navbar Right Menu-->
          <div class="navbar-custom-menu">
            <ul class="top-nav">
              <!--Notification Menu-->
            
              <!-- User Menu-->
			 
              <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu">
                  <li><a href=""><i class="fa fa-cog fa-lg"></i> Tài khoản</a></li>                
                  <li><a href="{{route('admin.user.logout')}}"><i class="fa fa-sign-out fa-lg"></i> Đăng xuất</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>