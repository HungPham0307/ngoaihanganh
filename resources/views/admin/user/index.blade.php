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
     <a href="{{route('admin.user.getadd')}}">
      Thêm quản lí
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
        <form action="{{route('admin.user.del')}}" method="post" id="xoa" >
          {{csrf_field()}}
          <table class="table table-hover table-bordered" id="sampleTable">
           <thead>
            <tr>
              <th style="text-align: center;">ID</th>
              <th style="text-align: center;" >UserName </th>
              <th style="text-align: center;" >FullName</th>
              <th style="text-align: center;" >Email </th>
              @if(Session::has("name") &&
              Session::get("name")=="admin" )
              <th style="text-align: center;" >Trạng thái</th>
              @endif
              <th style="text-align: center;" >
               <input type="submit" value="Delete" name="smXoa" class="xoa" onclick="return confirm('Bạn có chắc chắn muốn xóa không ?') "
               style="border: 3px; border-radius: 3px; background-color: dodgerblue;">
             </th>

           </tr>
         </thead>
         <tbody class= "hienthigopy">

           @foreach($objUser as $val )

           @php
           $id = $val ->id;
           $urlEdit = route('admin.user.getedit',$id);

           @endphp

           <tr>
            <td style="text-align: center;" >{{$id}}</td>
            <td style="text-align: center;" >{{$val->username}}</td>
            <td style="text-align: center;" >{{$val->fullname}}</td>
            <td style="text-align: center;" >{{$val->email}}</td>

            @if(Session::has("name") &&
            Session::get("name")=="admin" )
            <td style="text-align: center;">

              @if($val->username != 'admin')
              <span id="actice-{{$id}}">
                <a href="javascript:void(0)" onclick="getTrangThai({{$id}});">
                 @if($val->active == '1')
                 <img src="{{ $adminUrl }}/images/active.gif" alt="" />
                 @else
                 <img src="{{ $adminUrl }}/images/deactive.gif" alt="" />
                 @endif
               </a>
             </span>
             @endif
           </td>
           @endif
           <td style="text-align: center;" >
             <img src= "/templates/admin/images/edit.gif" />
             <a href="{{$urlEdit}}">Sửa </a>
             <img src= "/templates/admin/images/bin.gif" />
             <input   type="checkbox" value="{{$id}}" name="xoa[]"/>


           </td>

         </tr>

         @endforeach

       </tbody>
     </table>
   </form>
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
    var url='/admin/user/active/'+id;
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
