@extends('templates.admin.master')
@section('main-admin')
<div class="content-wrapper">

  <div class="row user">
    <div class="col-md-12">
      <div class="profile">
        <div class="info"><img class="user-img" src="/templates/admin/images/admin.jpg">
          <h4>
            @if(Session::has("name"))

            {{Session::get("name")}}
            @endif
          </h4>
        </div>
        <div class="cover-image"></div>
      </div>
    </div>
    <div class="page-title">

      <h4 style="margin-left: 37%; color: red; ">

        @if(Session::has("msg"))
        {{Session::get("msg")}}
        @endif

      </h4>
      
    </div>
    <div class="col-md-6" style="width: 100%;">
      <div class="card">
        <h3 class="card-title">Calendar</h3>
        <form action="{{route('admin.calendar.calendar')}}" method="post">
          {!! csrf_field() !!}
          <div class="card-body">
            <div class="form-group">
              <label class="control-label" >Tournament start date: *</label>
              <input style="width: 28%;height: 38px;" class="form-control" type="date" required name="date" value="">
            </div>
          <div class="card-footer">
            <button class="btn btn-primary icon-btn" name="smeditDM" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Get Schedule</button>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

</body>
</html>
@stop