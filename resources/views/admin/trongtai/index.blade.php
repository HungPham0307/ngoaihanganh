@extends('templates.admin.master')
@section('main-admin')
<div class="content-wrapper">
  <div class="row user">
    <div class="col-md-12">
      <div class="profile">
        <div class="info"><img class="user-img" src='{!! asset("files/trongtai/billgate.jpg") !!}'>
          <p></p>
        </div>
        <div class="cover-image"></div>
      </div>
    </div>
    <div class="page-title">
      @if(Session::has("name") && Session::get("name")=="admin" )
      <h3 class="add">
        <a href="{{route('admin.referee.getadd')}}">
          Add Referee
        </a>
      </h3>
      @endif
      <h3 style="margin-left: 37%; color:red">
        @if(Session::has("msg"))
        {{Session::get("msg")}}
        @endif
      </h3>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body  ">
            <form action="{{route('admin.referee.del')}}" method="post" id="xoa" >
              {{csrf_field()}}
              <table class="table table-hover table-bordered" id="sampleTable">
                <thead>
                  <tr>
                    <th style="text-align: center;">ID</th>
                    <th style="text-align: center;" >UserName </th>
                    <th style="text-align: center;" >FullName</th>
                    <th style="text-align: center;" >Email </th>
                    <th style="text-align: center;" >Images </th>
                    @if(Session::has("name") &&
                    Session::get("name")=="admin" )
                    <th style="text-align: center;" >Status</th>
                    @endif
                    <th style="text-align: center;" >
                      <input type="submit" value="Delete" name="smXoa" class="xoa" onclick="return confirm('Bạn có chắc chắn muốn xóa không ?') "
                      style="border: 3px; border-radius: 3px; background-color: dodgerblue;">
                    </th>

                  </tr>
                </thead>
                <tbody class= "hienthigopy">

                  @foreach($trongTai as $val )

                  @php
                  $id = $val ->id;
                  $urlEdit = route('admin.referee.getedit',$id);
                  @endphp

                  <tr>
                    <td style="text-align: center;vertical-align: middle;" >{{$id}}</td>
                    <td style="text-align: center;vertical-align: middle;" >{{$val->name}}</td>
                    <td style="text-align: center;vertical-align: middle;" >{{$val->fullname}}</td>
                    <td style="text-align: center;vertical-align: middle;" >{{$val->email}}</td>
                    <td style="text-align: center;vertical-align: middle;" >
                      <img style="width: 200px;height: 150px;" src='{!! asset("files/trongtai/$val->hinhanh") !!}'>
                    </td>
                    @if(Session::has("name") &&
                    Session::get("name")=="admin" )
                    <td style="text-align: center;vertical-align: middle;">

                      @if($val->username != 'admin')
                      <span id="actice-{{$id}}">
                        <a href="javascript:void(0)" onclick="getTrangThai({{$id}});">
                          @if($val->active == '1')
                          <img src= '/templates/admin/images/active.gif' alt="" />
                          @else
                          <img src= '/templates/admin/images/deactive.gif' alt="" />
                          @endif
                        </a>
                      </span>
                      @endif
                    </td>
                    @endif
                    <td style="text-align: center;vertical-align: middle;" >
                      <img src= '{!!asset("templates/admin/images/edit.gif")!!}' />
                      <a href="{{$urlEdit}}">Edit </a>
                      <img src= '{!!asset("templates/admin/images/bin.gif")!!}' />
                      <input   type="checkbox" value="{{$id}}" name="xoa[]"/>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </form>
            <div class="pagination-outter" style="text-align: center;">
              <ul class="pagination"> {{ $trongTai->links() }} </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- Javascripts-->

<script type="text/javascript">
  function getTrangThai(id)
  {
    var url='/admin/referee/active/'+id;
    var tmp="#actice-"+id;

    $.ajax({
      url:url,
      dataType: "html",
      success: function(result) {

        $(tmp).html(result);
      },
    });
  }
</script>

</body>
</html>
@stop
