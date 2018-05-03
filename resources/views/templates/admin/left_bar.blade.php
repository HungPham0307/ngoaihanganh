  <aside class="main-sidebar hidden-print">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image"><img class="img-circle" src="{{$imgUrl}}/admin.png" alt="User Image"></div>
        <div class="pull-left info">
          <p>Admin</p>
          <p class="designation"></p>
        </div>
      </div>
      <!-- Sidebar Menu-->
      <ul class="sidebar-menu">
        <li class="{{Request::Segment(2)==='calendar' and Request::Segment(3)!='show'  ?'active' : ''}}"><a href="{{route('admin.calendar.index')}}"><i class="fa fa-dashboard"></i><span>Calendar</span></a></li>
        <li class="{{Request::Segment(2)==='referee' ?'active' : ''}}"><a href="{{route('admin.referee.index')}}"><i class="fa fa-dashboard"></i><span>Referee</span></a></li>
        <li class="{{Request::Segment(2)==='football' ?'active' :''}}"><a href="{{route('admin.football.index')}}"><i class="fa fa-dashboard"></i><span>Football</span></a></li>
        <li class="{{Request::Segment(2)==='update' ?'active' :''}}"><a href="{{route('admin.update.index')}}"><i class="fa fa-dashboard"></i><span>Update the Match</span></a></li>
        <li class="{{Request::Segment(3)==='show' ?'active' : ''}}"><a href="{{route('admin.calendar.show')}}"><i class="fa fa-dashboard"></i><span>View Calendar</span></a></li>
     </ul>
   </section>
 </aside>
