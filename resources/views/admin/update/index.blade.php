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
        <h3 class="card-title">Please select match round </h3>
        <form action="{{route('admin.update.search')}}" method="post">
          {!! csrf_field() !!}
          <div class="card-body">
            @php
            $round = range(1,38);
            @endphp
            <div class="form-group">
              <div class="" style="width: 15%;">
                <select class="form-control" id="select" name="round">
                  @foreach ($round as $key=>$val)
                    <option value="{{$val}}"  >{{ $val }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          <div class="card-footer">
            <button class="btn btn-primary icon-btn" name="smeditDM" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Search</button>
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
