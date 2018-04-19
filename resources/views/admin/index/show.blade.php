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
       <p></p>
     </div>
     <div class="cover-image"></div>
   </div>
 </div>
 <div class="page-title">
   @if(Session::has("name") && Session::get("name")=="admin" )
   <h3 class="add">
     <a href=" {{ route('admin.calendar.export')}}">
      Download
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
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th style="text-align: center;">Round</th>
              <th style="text-align: center;">Match</th>
              <th style="text-align: center;">Date </th>
              <th style="text-align: center;">Time </th>
              <th style="text-align: center;">Team</th>
              <th style="text-align: center;">Stadium</th>
            </tr>
          </thead>
          <tbody>
            @php
            $count = 1;
            @endphp

            @foreach ($muaGiai as $key => $val)
            <tr>

              @if ($key % 10 == 0)
              <td rowspan="10" style="text-align: center;    vertical-align: middle;">{{$val->vongdau}}</td>
              @endif
              <td style="text-align: center;">{{$count}}</td>
              <td style="text-align: center;">{{ date('l, d M, Y', strtotime($val->date)) }}</td>
              <td style="text-align: center;">{{ Carbon\Carbon::parse($val->time)->format('H:i') }} PM</td>
              @if ($result[$val->doi_nha] == $val->sanvandong_id)
                <td style="text-align: center;"> {{ $val->doi_nha }} vs  {{ $val->doi_khach }}</td>
              @else
              <td style="text-align: center;"> {{ $val->doi_khach }} vs  {{ $val->doi_nha }}</td>
              @endif
              <td style="text-align: center;">{{ $val->sanvandong->name }}</td>
            </tr>
            @php
            $count++;
            @endphp
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>

</body>
</html>
@stop
